<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\Product;
use App\Models\BrokerKood;
use App\Models\CityKood;
use App\Models\KoodReq;

use Rafwell\Simplegrid\Grid;
use Morilog\Jalali\Jalalian;
use App\User;
use Auth;

class BrokerKoodController extends Controller
{   
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','managerJahad','nazer']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
    	// get all the samRequest
    	
        
        if(Auth::user()->hasRole('admin'))
        {
            $crumb[1] = ['title'=>'کارگزاران','url'=>'','class'=>'active'];
            $gridQuery = User::join('role_user','users.id','=','role_user.user_id')
                ->join('cities','cities.id','=','users.city_id')
                ->where('role_user.role_id',11);
        }
		elseif(Auth::user()->hasRole('managerJahad'))
        {
            $crumb[1] = ['title'=>'کارگزاران شهرستان '.Auth::user()->city->title,'url'=>'','class'=>'active'];
            $gridQuery = User::join('role_user','users.id','=','role_user.user_id')
                ->join('cities','cities.id','=','users.city_id')
                ->where('users.city_id',auth::user()->city_id)
                ->where('role_user.role_id',11);
        }
        else
        {
            $crumb[1] = ['title'=>'کارگزاران','url'=>'','class'=>'active'];
            $gridQuery = User::join('role_user','users.id','=','role_user.user_id')
                ->join('cities','cities.id','=','users.city_id')
                ->where('role_user.role_id',11);
        }
        
        
        $Grid = new Grid($gridQuery, 'users');
        $Grid->fields([
          'name'=>trans('validation.attributes.name'),
            'company'=>'نام شرکت',
            'codemelli'=>'کد ملی',
            'tbl_cities.title' => 'شهر',
            'mobile'=>trans('validation.attributes.mobile'),
          
        ])->actionFields([
            'tbl_users.id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view',[
                'icon' => 'fas fa-eye',
                'onlyIcon' => true
            ]);
         
        // load the view and pass the samRequest
    	return view("admin.cityKood.list")->with([
        //    "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }
    
    public function view($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','managerJahad','nazer']);
        
    	$model = User::find($id);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'تخصیص کود','url'=>'cityKood/all','class'=>''];
        if(Auth::user()->hasRole('managerJahad'))
            $crumb[1] = ['title'=>'کارگزاران شهرستان '.Auth::user()->city->title,'url'=>'brokerKood/all','class'=>''];
        else
            $crumb[1] = ['title'=>'کارگزاران','url'=>'brokerKood/all','class'=>''];
        $crumb[2] = ['title'=>'تخصیص کود '.$model->name,'url'=>'','class'=>'active'];
    	// get all the samRequest
        $koods = Product::where('category_id',3)->get();
        
        // load the view and pass the samRequest
    	return view("admin.brokerKood.view")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "koods"=>$koods
        ]);
    }
    public function brokerView(Request $request)
    {
        $request->user()->authorizeRoles(['admin','broker']);
        
    	$model = User::find(Auth::id());
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'تخصیص کود '.$model->name,'url'=>'','class'=>'active'];
    	// get all the samRequest
        $koods = Product::where('category_id',3)->get();
        
        // load the view and pass the samRequest
    	return view("admin.brokerKood.broker_view")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "koods"=>$koods
        ]);
    }
    
    public function brokerReport($id,$broker = null,  Request $request)
    {
        $request->user()->authorizeRoles(['admin','broker','managerJahad','nazer']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
        if($broker)
        {
            $model = User::find($broker);
           
            $crumb[1] = ['title'=>'کارگزاران','url'=>'brokerKood/all','class'=>''];
            $crumb[2] = ['title'=>'تخصیص کود '.$model->name,'url'=>'brokerKood/'.$model->id.'/view','class'=>''];
        }
        else
        {
            $model = User::find(Auth::id());
            $crumb[1] = ['title'=>'تخصیص کود '.$model->name,'url'=>'brokerKood/view','class'=>''];
        }
        $kood = Product::find($id);
        
        $crumb[3] = ['title'=>'گزارش '.$kood->title,'url'=>'','class'=>'active'];
    	// get all the samRequest
        
        
        $gridQuery = KoodReq::join('users','users.id','=','kood_reqs.user_id')
                ->join('products','products.id','=','kood_reqs.product_id')
                ->where('kood_reqs.broker_id',$model->id)
                ->where('kood_reqs.kood_id',$id)
                ->where('kood_reqs.status', '>', 0)
                ->orderBy('kood_reqs.make_date','desc');
        
        
        $Grid = new Grid($gridQuery, 'kood_reqs');
        $Grid->fields([
          'tbl_users.name'=>trans('validation.attributes.name'),
            'tbl_products.title'=>'محصول',
            'tbl_kood_reqs.value' => 'مقدار (پاکت 50 کیلویی)',
            'tbl_kood_reqs.make_date'=>trans('validation.attributes.date'),
          
        ])->processLine(function($row){
           $row['make_date'] = jdate($row['make_date'])->format('%d %B %Y');
            return $row; //Do not forget to return the row
        })->actionFields([
			
            'tbl_kood_reqs.id' //The fields used for process actions. those not are showed 
        ]);
        
//        $Grid->action(trans('validation.attributes.view'), '{id}/view',[
//                'icon' => 'fas fa-eye',
//                'onlyIcon' => true
//            ]);
        
        
        // load the view and pass the samRequest
    	return view("admin.brokerKood.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
            "grid"=>$Grid,
        ]);
    }
    
    public function add($id,$kood, Request $request)
    {
        $request->user()->authorizeRoles(['admin','managerJahad']);
     
    	$model = User::find($id);
        $kood = Product::find($kood);

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        if(Auth::user()->hasRole('managerJahad'))
            $crumb[1] = ['title'=>'کارگزاران شهرستان '.Auth::user()->city->title,'url'=>'brokerKood/all','class'=>''];
        else
            $crumb[1] = ['title'=>'کارگزاران','url'=>'brokerKood/all','class'=>''];
        $crumb[2] = ['title'=>'تخصیص کود  '.$model->name,'url'=>'brokerKood/'.$id.'/view','class'=>''];
        $crumb[3] = ['title'=>'افزایش سهمیه کود '.$kood->title,'url'=>'','class'=>'active'];

        // load the create form (app/views/handyValue/create.blade.php)
        return view("admin.brokerKood.create")->with([
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
        $request->user()->authorizeRoles(['admin','managerJahad']);
     
    	$model = User::find(Input::get('id'));
        $kood = Product::find(Input::get('kood')); 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'value' => ['required','lte:'.$model->city->koodVal($kood->id),'min:1']
        );
        $validator = Validator::make(Input::all(), $rules);

        
        // process the login
        if ($validator->fails()) {
            return Redirect::to('brokerKood/'.$model->id.'/add/'.$kood->id)
                ->withErrors($validator)->withInput();
        } else {
            // handyValue
            $new = new BrokerKood;
            $new->broker_id = $model->id;
            $new->kood_id = $kood->id;
            $new->tonne = Input::get('value');
            $new->value = (Input::get('value') * 1000) / 50;
            $new->type = 1;
            $new->user_id = Auth::id();
            $new->comment = 'افزایش سهمیه کود '.$kood->title.' کارگزار '.$model->name;
            $new->save();

            $new = new CityKood;
            $new->city_id = $model->city->id;
            $new->kood_id = $kood->id;
            $new->tonne = Input::get('value');
            $new->value = (Input::get('value') * 1000) / 50;
            $new->type = 2;
            $new->status = 1;
            $new->rdate = date("Y-m-d");
            $new->user_id = Auth::id();
            $new->comment = 'افزایش سهمیه کود '.$kood->title.' کارگزار '.$model->name;
            $new->save();
            // redirect
            Session::flash('message', 'افزایش سهمیه کود '.$kood->title.' برای ;کارگزار '.$model->name.' با موفقیت انجام شد.');
            return Redirect::to('brokerKood/'.$model->id.'/view');
        }
    }
    
    
    public function remove($id,$kood, Request $request)
    {
        $request->user()->authorizeRoles(['admin','managerJahad']);
     
    	$model = User::find($id);
        $kood = Product::find($kood);
		$value = $model->koodVal($kood->id);

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        if(Auth::user()->hasRole('managerJahad'))
            $crumb[1] = ['title'=>'کارگزاران شهرستان '.Auth::user()->city->title,'url'=>'brokerKood/all','class'=>''];
        else
            $crumb[1] = ['title'=>'کارگزاران','url'=>'brokerKood/all','class'=>''];
        $crumb[2] = ['title'=>'کارگزار '.$model->name,'url'=>'brokerKood/'.$id.'/view','class'=>''];
        $crumb[3] = ['title'=>'کاهش سهمیه کود '.$kood->title,'url'=>'','class'=>'active'];

        // load the create form (app/views/handyValue/create.blade.php)
        return view("admin.brokerKood.remove")->with([
            "crumb"=>$crumb,
            "model"=>$model,
            'kood'=>$kood,
			'value'=>$value
        ]);
    }

	/**
     * HandyValue a newly created resource in storage.
     *
     * @return Response
     */

    public function removeKood(Request $request)
    {
        $request->user()->authorizeRoles(['admin','managerJahad']);
     
    	$model = User::find(Input::get('id'));
        $kood = Product::find(Input::get('kood')); 
		$value = $model->koodVal($kood->id);
		
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'value' => ['required','lte:'.$value,'min:1']
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('brokerKood/'.$model->id.'/remove/'.$kood->id)
                ->withErrors($validator)->withInput();
        } else {
            // handyValue
            $new = new BrokerKood;
            $new->broker_id = $model->id;
            $new->kood_id = $kood->id;
            $new->tonne = Input::get('value');
            $new->value = (Input::get('value') * 1000) / 50;
            $new->type = 0;
            $new->user_id = Auth::id();
            $new->comment = 'کاهش سهمیه کود '.$kood->title.' کارگزار '.$model->name;
            $new->save();
            
            $new = new CityKood;
            $new->city_id = $model->city->id;
            $new->kood_id = $kood->id;
            $new->tonne = Input::get('value');
            $new->value = (Input::get('value') * 1000) / 50;
            $new->type = 2;
            $new->status = -1;
            $new->rdate = date("Y-m-d");
            $new->user_id = Auth::id();
            $new->comment = 'کاهش سهمیه کود '.$kood->title.' کارگزار '.$model->name;
            $new->save();

            // redirect
            Session::flash('message', 'کاهش سهمیه کود '.$kood->title.' برای کارگزار '.$model->name.' با موفقیت انجام شد.');
            return Redirect::to('brokerKood/'.$model->id.'/view');
        }
    }
}
