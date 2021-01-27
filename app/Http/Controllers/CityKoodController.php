<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\City;
use App\Models\Product;
use App\Models\CityKood;

use Rafwell\Simplegrid\Grid;
use App\User;
use Auth;

class CityKoodController extends Controller
{   
	public function __construct()
    {
		$this->middleware('auth');
    }
	
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis','nazer']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'تخصیص کود','url'=>'','class'=>'active'];
    	// get all the samRequest
    	$model = City::get();
        
    	$gridQuery = City::where('ostan_id',17)
                ->orderBy('title', 'asc');
        
        $Grid = new Grid($gridQuery, 'citys');
        $Grid->fields([
          'title'=>trans('validation.attributes.code'),
          
        ])->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view',[
                'icon' => 'fas fa-eye',
                'onlyIcon' => true
            ]);
        
        // load the view and pass the samRequest
    	return view("admin.cityKood.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }
    
    public function view($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis','nazer']);
        
    	$model = City::find($id);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'تخصیص کود','url'=>'cityKood/all','class'=>''];
        $crumb[2] = ['title'=>'شهرستان '.$model->title,'url'=>'','class'=>'active'];
    	// get all the samRequest
        $koods = Product::where('category_id',3)->get();
        
        // load the view and pass the samRequest
    	return view("admin.cityKood.view")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "koods"=>$koods
        ]);
    }
    
    public function add($id,$kood, Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis']);
     
    	$model = City::find($id);
        $kood = Product::find($kood);

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'تخصیص کود','url'=>'cityKood/all','class'=>''];
        $crumb[2] = ['title'=>'شهرستان '.$model->title,'url'=>'','class'=>''];
        $crumb[3] = ['title'=>'افزایش سهمیه کود '.$kood->title,'url'=>'','class'=>'active'];

        // load the create form (app/views/handyValue/create.blade.php)
        return view("admin.cityKood.create")->with([
            "crumb"=>$crumb,
            "model"=>$model,
            'kood'=>$kood
        ]);
    }

	/**
     * HandyValue a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis']);
     
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'value' => ['required','min:1']
        );
        $validator = Validator::make(Input::all(), $rules);

    	$model = City::find(Input::get('id'));
        $kood = Product::find(Input::get('kood')); 
        
        // process the login
        if ($validator->fails()) {
            return Redirect::to('cityKood/'.$model->id.'/add/'.$kood->id)
                ->withErrors($validator)->withInput();
        } else {
            // handyValue
            $new = new CityKood;
            $new->city_id = $model->id;
            $new->kood_id = $kood->id;
            $new->tonne = Input::get('value');
            $new->value = (Input::get('value') * 1000) / 50;
            $new->type = 1;
            $new->status = 1;
            $new->rdate = date("Y-m-d");
            $new->user_id = Auth::id();
            $new->comment = 'افزایش سهمیه کود '.$kood->title.' شهرستان '.$model->title;
            $new->save();

            // redirect
            Session::flash('message', 'افزایش سهمیه کود '.$kood->title.' برای شهرستان '.$model->title.' با موفقیت انجام شد.');
            return Redirect::to('cityKood/'.$model->id.'/view');
        }
    }
    
    
    public function remove($id,$kood, Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis']);
     
    	$model = City::find($id);
        $kood = Product::find($kood);

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'تخصیص کود','url'=>'cityKood/all','class'=>''];
        $crumb[2] = ['title'=>'شهرستان '.$model->title,'url'=>'','class'=>''];
        $crumb[3] = ['title'=>'کاهش سهمیه کود '.$kood->title,'url'=>'','class'=>'active'];

        // load the create form (app/views/handyValue/create.blade.php)
        return view("admin.cityKood.remove")->with([
            "crumb"=>$crumb,
            "model"=>$model,
            'kood'=>$kood
        ]);
    }

	/**
     * HandyValue a newly created resource in storage.
     *
     * @return Response
     */

    public function removeKood(Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis']);
     
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'value' => ['required']
        );
        $validator = Validator::make(Input::all(), $rules);

    	$model = City::find(Input::get('id'));
        $kood = Product::find(Input::get('kood')); 
        
        // process the login
        if ($validator->fails()) {
            return Redirect::to('cityKood/'.$model->id.'/remove/'.$kood->id)
                ->withErrors($validator)->withInput();
        } else {
            // handyValue
            $new = new CityKood;
            $new->city_id = $model->id;
            $new->kood_id = $kood->id;
            $new->tonne = Input::get('value');
            $new->value = (Input::get('value') * 1000) / 50;
            $new->type = 1;
            $new->status = -1;
            $new->rdate = date("Y-m-d");
            $new->user_id = Auth::id();
            $new->comment = 'کاهش سهمیه کود '.$kood->title.' شهرستان '.$model->title;
            $new->save();

            // redirect
            Session::flash('message', 'کاهش سهمیه کود '.$kood->title.' برای شهرستان '.$model->title.' با موفقیت انجام شد.');
            return Redirect::to('cityKood/'.$model->id.'/view');
        }
    }
}
