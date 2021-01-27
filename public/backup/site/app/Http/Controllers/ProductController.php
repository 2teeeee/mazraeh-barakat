<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\Product;
use Rafwell\Simplegrid\Grid;
use App\User;
use Image;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function all(Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
    	// get all the azmayeshgah
    	
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'product\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'product\create','class'=>'btn-success','icon'=>'pencil'];
        
        $query = Product::where('category_id',1);

        $Grid = new Grid($query, 'productss');
    	
        $Grid->fields([
          'title'=>trans('validation.attributes.title'),
          'code'=>trans('validation.attributes.code'),
          'bagValue'=>trans('validation.attributes.bagValue'),
          'price'=>trans('validation.attributes.price'),
          
        ])->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.edit'), '{id}/edit')
            ->action(trans('validation.attributes.delete'), '{id}', [
                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
                'method'=>'DELETE',
            ]);
        
        // load the view and pass the azmayeshgah
    	return view("admin.product.all")->with([
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
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'product\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'product\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'product/all','class'=>'btn-info','icon'=>'book'];


        // load the create form (app/views/product/create.blade.php)
        return view("admin.product.create")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
        ]);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title' => ['required'],
            'code' => ['nullable'],
            'bagValue' => ['nullable', 'numeric'],
            'price' => ['nullable', 'numeric'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('product/create')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new Product;
            $model->title = Input::get('title');
            $model->category_id = 1;
            $model->code = Input::get('code');
            $model->bagValue = Input::get('bagValue');
            $model->price = Input::get('price');
        
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('product/all');
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
        
        // get the product
        $model = Product::find($id);

        // show the view and pass the product to it
        return View('admin.product.show')->with(
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
        
        // get the product
        $model = Product::find($id);
        
        $btn[0] = ['title'=>'مدیریت','url'=>'product/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'product/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the product
        return View('admin.product.edit')->with([
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
            'code' => ['nullable'],
            'bagValue' => ['nullable', 'numeric'],
            'price' => ['nullable', 'numeric'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('product/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = Product::find($id);
            $model->title = Input::get('title');
            $model->category_id = 1;
            $model->code = Input::get('code');
            $model->bagValue = Input::get('bagValue');
            $model->price = Input::get('price');
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('product/all');
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
        $model = Product::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('product/all');
    }
    
}
