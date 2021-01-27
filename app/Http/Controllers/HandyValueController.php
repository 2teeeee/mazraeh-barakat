<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\HandyValue;
use Rafwell\Simplegrid\Grid;

class HandyValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.info.user');
    }
    
    public function all($item,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
    	// get all the handyValue
    	$model = HandyValue::all();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'/handyValue/all/'.$item,'class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>"/handyValue/create/$item",'class'=>'btn-success','icon'=>'pencil'];
        $query = HandyValue::where("handy_id",$item);
        $Grid = new Grid($query, 'handyValues');
    	
        $Grid->fields([
          'title'=>trans('validation.attributes.title'),
        ])->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.edit'), url('/handyValue/{id}/edit'),['icon'=>'fa fa-pencil fa-2x','onlyIcon'=>true])
            ->action(trans('validation.attributes.delete'), '{id}', [
                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
                'method'=>'DELETE',
                'icon'=>'fa fa-trash-o fa-2x',
                'onlyIcon'=>true
            ]);
        
        // load the view and pass the handyValue
    	return view("admin.handyValue.all")->with([
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

    public function create($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'/handyValue/all/'.$id,'class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'/handyValue/create/'.$id,'class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/handyValue/all/'.$id,'class'=>'btn-info','icon'=>'book'];

        // load the create form (app/views/handyValue/create.blade.php)
        return view("admin.handyValue.create")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
            'cat'=>$id
        ]);
    }

	/**
     * HandyValue a newly created resource in storage.
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
            return Redirect::to('handyValue/create')
                ->withErrors($validator)->withInput();
        } else {
            // handyValue
            $model = new HandyValue;
            $model->title = Input::get("title");
            $cat = Input::get("cat");
            $model->handy_id = $cat;
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('handyValue/all/'.$cat);
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
     
        // get the handyValue
        $model = HandyValue::find($id);

        // show the view and pass the handyValue to it
        return View('admin.handyValue.show')->with(
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
     
        // get the handyValue
        $model = HandyValue::find($id);
        
        
        $btn[0] = ['title'=>'مدیریت','url'=>'/handyValue/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'/handyValue/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the handyValue
        return View('admin.handyValue.edit')->with([
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
            return Redirect::to('handyValue/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // handyValue
            $model = HandyValue::find($id);
            $model->title = Input::get('title');
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('handyValue/all/'.$model->handy_id);
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
        $model = HandyValue::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('handyValue/all');
    }
}
