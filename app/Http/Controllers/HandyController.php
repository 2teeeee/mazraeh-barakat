<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\Handy;
use Rafwell\Simplegrid\Grid;

class HandyController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.info.user');
    }
    
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
    	// get all the handy
    	$model = Handy::all();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\handy\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\handy\create','class'=>'btn-success','icon'=>'pencil'];
        
        $Grid = new Grid(Handy::query(), 'handys');
    	
        $Grid->fields([
          'title'=>trans('validation.attributes.title'),
        ])->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.edit'), '{id}/edit',['icon'=>'fa fa-pencil fa-2x','onlyIcon'=>true])
                ->action('گزینه ها', '{id}/item',['icon'=>'fa fa-list fa-2x','onlyIcon'=>true])
            ->action(trans('validation.attributes.delete'), '{id}', [
                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
                'method'=>'DELETE',
                'icon'=>'fa fa-trash-o fa-2x',
                'onlyIcon'=>true
            ]);
        
        // load the view and pass the handy
    	return view("admin.handy.all")->with([
            "model"=>$model,
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\handy\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\handy\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/handy/all','class'=>'btn-info','icon'=>'book'];


        // load the create form (app/views/handy/create.blade.php)
        return view("admin.handy.create")->with([
            "crumb"=>$crumb,
            "btn"=>$btn
        ]);
    }

	/**
     * Handy a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title' => ['required']
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('handy/create')
                ->withErrors($validator)->withInput();
        } else {
            // handy
            $model = new Handy;
            $model->title = Input::get("title");
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('handy/all');
        }
    }

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
        // get the handy
        $model = Handy::find($id);

        // show the view and pass the handy to it
        return View('admin.handy.show')->with(
            'model', $model
        );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
        // get the handy
        $model = Handy::find($id);
        
        
        $btn[0] = ['title'=>'مدیریت','url'=>'/handy/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'/handy/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the handy
        return View('admin.handy.edit')->with([
            'model'=>$model,
            'btn'=>$btn
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title' => ['required'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('handy/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // handy
            $model = Handy::find($id);
            $model->title = Input::get('title');
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('handy/all');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
        // delete
        $model = Handy::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('handy/all');
    }
    public function item($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
        return Redirect::to('handyValue/all/'.$id);
    }
}
