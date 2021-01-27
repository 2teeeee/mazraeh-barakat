<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\BrokerKood;
use App\Models\CityKood;
use App\Models\City;
use App\Models\KoodReq;
use App\Models\Product;

use Morilog\Jalali;
use Rafwell\Simplegrid\Grid;
use App\User;
use Auth;
use DB;

class ReportController extends Controller
{   
	public function __construct()
    {
		$this->middleware('auth');
    }
	
    public function cities(Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
    	// get all the samRequest
    	
        $crumb[1] = ['title'=>'کارگزاران','url'=>'','class'=>'active'];
        $gridQuery = CityKood::join('cities','cities.id','=','city_koods.city_id')
                ->groupBy('city_koods.city_id');
        
        $Grid = new Grid($gridQuery, 'users');
        $Grid->fields([
            'tbl_cities.title' => 'شهر',
            'broker'=>[
                'label'=>'کارگزاران (نفر)',
                'field'=>"tbl_city_koods.city_id"
            ],
            'farmer'=>[
                'label'=>'بهره برداران (نفر)',
                'field'=>"tbl_city_koods.city_id"
            ],
          
        ])->actionFields([
            'tbl_city_koods.city_id' //The fields used for process actions. those not are showed 
        ])->processLine(function($row){
            //This function will be called for each row
            $city = City::find($row['broker']);
            $row['broker'] = $city->id;
            $row['farmer'] = 12;
            //Do more you need on this row
            return $row; //Do not forget to return the row
        });
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view',[
                'icon' => 'fas fa-eye',
                'onlyIcon' => true
            ]);
         
        // load the view and pass the samRequest
    	return view("admin.report.list")->with([
        //    "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }
    
	public function koodRep(Request $request)
    {
		
        $request->user()->authorizeRoles(['admin','takhsis','managerJahad','nazer']);
        
		$crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
        $crumb[1] = ['title'=>'گزارش تخصیص کود','url'=>'','class'=>'active'];
		
        $citys = City::all();
		
		$koods = Product::where('category_id',3)->get();
		$kood_id = Product::where('category_id',3)->first();
		
		$response = KoodReq::select(DB::raw('tbl_products.title as title'),
								 DB::raw('sum(tbl_kood_reqs.value) as kise'),
								 DB::raw('ROUND(sum(tbl_kood_reqs.value * 50 / 1000),2) as tone'),
								 DB::raw('sum(tbl_kood_reqs.price_all) as price'),
								 DB::raw('count(tbl_kood_reqs.user_id) as keshavarz'),
								 DB::raw('sum(tbl_kood_reqs.sath) as sathZirKesht'))
			->join('products','products.id','=','kood_reqs.kood_id')
			->where('kood_reqs.status','>',0)
			->where('kood_reqs.kood_id',$kood_id->id)
			->groupBy('kood_reqs.kood_id');
	
		
		$response = $response->get();
		
    	return view("admin.report.koods")->with([
            "crumb" => $crumb,
			"citys" => $citys,
			"response" => $response,
			'koods' => $koods,
			"ct_id" => 0,
			"ch" => 1,
			"brokers" => [],
			"broker_id" => 0,
			"startDate" => "",
			"endDate" => "",
			"kood_id" => $kood_id->id
        ]);
    }
	
	public function koodPost(Request $request)
    {
        $request->user()->authorizeRoles(['admin','takhsis','managerJahad','nazer']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
    	// get all the samRequest
    	
        $crumb[1] = ['title'=>'گزارش تخصیص کود','url'=>'','class'=>'active'];
		
        $citys = City::all();
		$koods = Product::where('category_id',3)->get();
		
		$response = KoodReq::select(DB::raw('tbl_products.title as title'),
							 	DB::raw('sum(tbl_kood_reqs.value) as kise'),
							 	DB::raw('ROUND(sum(tbl_kood_reqs.value * 50 / 1000),2) as tone'),
							 	DB::raw('sum(tbl_kood_reqs.price_all) as price'),
							 	DB::raw('count(tbl_kood_reqs.user_id) as keshavarz'),
							 	DB::raw('sum(tbl_kood_reqs.sath) as sathZirKesht'),
							 	'users.name as name',
							 	'users.company as company',
							   	'users.id as id')
			->join('products','products.id','=','kood_reqs.kood_id')
			->join('users','users.id','=','kood_reqs.broker_id')
			->where('kood_reqs.status','>',0)
			->groupBy('kood_reqs.broker_id')
			->groupBy('kood_reqs.kood_id');
	
		$brokers = [];
		if(Input::get('city_id') <> '')
		{
			$response = $response->where('kood_reqs.ct_id',Input::get('city_id'));
			
			$ct = City::where('ct_id',Input::get('city_id'))->first();
			$brokers = User::join('role_user','users.id','=','role_user.user_id')
                ->where('role_user.role_id',11)
                ->where('users.city_id',$ct->id)
                ->get();
		}
		
		if(Input::get('broker_id') <> '')
		{
			$response->where('kood_reqs.broker_id',Input::get('broker_id'));
		}
		if(Input::get('kood_id') <> '')
		{
			$response->where('kood_reqs.kood_id',Input::get('kood_id'));
		}
		if(Input::get('startDate') <> '')
		{
			$st = Input::get('startDate');
			$dt = explode('/', $st);
			
			$yearStart =  $dt[0];
			$monthStart = $dt[1];
			$dayStart = $dt[2];
			
			$start = \Morilog\Jalali\CalendarUtils::toGregorian($yearStart, $monthStart, $dayStart); // [2016, 5, 7]
			$startDate = $start[0].'-'.$start[1].'-'.$start[2];
			
			$response->whereDate('kood_reqs.make_date','>=',$startDate);
		}
		if(Input::get('endDate') <> '')
		{
			$st = Input::get('endDate');
			$dt = explode('/', $st);
			
			$yearEnd =  $dt[0];
			$monthEnd = $dt[1];
			$dayEnd = $dt[2];
			
			$end = \Morilog\Jalali\CalendarUtils::toGregorian($yearEnd, $monthEnd, $dayEnd); // [2016, 5, 7]
			$endDate = $end[0].'-'.$end[1].'-'.$end[2];
			
			$response->whereDate('kood_reqs.make_date','<=',$endDate);
		}
		
		$response = $response->get();
        // load the view and pass the samRequest
    	return view("admin.report.koods")->with([
            "crumb" => $crumb,
			"citys" => $citys,
			"response" => $response,
			'koods' => $koods,
			"ct_id" => Input::get('city_id'),
			"ch" => 0,
			"brokers" => $brokers,
			"broker_id" => Input::get('broker_id'),
			"startDate" => Input::get('startDate'),
			"endDate" => Input::get('endDate'),
			"kood_id" => Input::get('kood_id')
        ]);
    }
	
	public function getBroker()
	{
	
		$id = Input::get('id');
		
		if($id != '')
		{
			$ct = City::where('ct_id',$id)->first();
			$brokers = User::join('role_user','users.id','=','role_user.user_id')
                ->where('role_user.role_id',11)
                ->where('users.city_id',$ct->id)
                ->get();
		}
		else
		{
			$brokers = User::join('role_user','users.id','=','role_user.user_id')
                ->where('role_user.role_id',11)
                ->get();
		}
		
        return json_encode($brokers);
    }
	
	
	public function brokerRep(Request $request)
    {
		
        $request->user()->authorizeRoles(['admin','manager','programmer','broker','nazer']);
        
		$crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
        $crumb[1] = ['title'=>'گزارش تخصیص کود','url'=>'','class'=>'active'];
		
		
		$response = KoodReq::select(DB::raw('tbl_products.title as title'),
								 DB::raw('sum(tbl_kood_reqs.value) as kise'),
								 DB::raw('ROUND(sum(tbl_kood_reqs.value * 50 / 1000),2) as tone'),
								 DB::raw('sum(tbl_kood_reqs.price_all) as price'))
			->join('products','products.id','=','kood_reqs.kood_id')
			->where('kood_reqs.status','>',0)
			->where('kood_reqs.broker_id',Auth::id())
			->groupBy('kood_reqs.kood_id');
	
		if(Input::get('startDate') <> '')
		{
			$st = Input::get('startDate');
			$dt = explode('/', $st);
			
			$yearStart =  $dt[0];
			$monthStart = $dt[1];
			$dayStart = $dt[2];
			
			$start = \Morilog\Jalali\CalendarUtils::toGregorian($yearStart, $monthStart, $dayStart); // [2016, 5, 7]
			$startDate = $start[0].'-'.$start[1].'-'.$start[2];
			
			$response->whereDate('kood_reqs.make_date','>=',$startDate);
		}
		if(Input::get('endDate') <> '')
		{
			$st = Input::get('endDate');
			$dt = explode('/', $st);
			
			$yearEnd =  $dt[0];
			$monthEnd = $dt[1];
			$dayEnd = $dt[2];
			
			$end = \Morilog\Jalali\CalendarUtils::toGregorian($yearEnd, $monthEnd, $dayEnd); // [2016, 5, 7]
			$endDate = $end[0].'-'.$end[1].'-'.$end[2];
			
			$response->whereDate('kood_reqs.make_date','<=',$endDate);
		}
		
		$response = $response->get();
		
    	return view("admin.report.brokerKoods")->with([
            "crumb" => $crumb,
			"response" => $response,
			"brokers" => [],
			"broker_id" => 0,
			"startDate" => "",
			"endDate" => ""
        ]);
    }
	
	public function cityBrokers(Request $request)
    {
        $request->user()->authorizeRoles(['admin','managerJahad']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
    	// get all the samRequest
    	
        $crumb[1] = ['title'=>'گزارش شهرستان '.Auth::user()->city->title.' به تفکیک کارگزار','url'=>'','class'=>'active'];
		
		$koods = Product::where('category_id',3)->get();
		$fKood = Product::where('category_id',3)->first();
		
		$response = KoodReq::select(DB::raw('tbl_products.title as title'),
								 DB::raw('sum(tbl_kood_reqs.value) as kise'),
								 DB::raw('ROUND(sum(tbl_kood_reqs.value * 50 / 1000),2) as tone'),
								 DB::raw('sum(tbl_kood_reqs.price_all) as price'),
								 DB::raw('count(tbl_kood_reqs.user_id) as keshavarz'),
								 DB::raw('sum(tbl_kood_reqs.sath) as sathZirKesht'),
								 'users.name as name',
								 'users.company as company',
								   'users.id as id')
			->join('products','products.id','=','kood_reqs.kood_id')
			->join('users','users.id','=','kood_reqs.broker_id')
			->where('kood_reqs.status','>',0)
			->where('kood_reqs.kood_id',$fKood->id)
			->groupBy('kood_reqs.broker_id');
	
		
		if(Auth::user()->hasRole('managerJahad'))
        {
            $response->where('kood_reqs..ct_id',Auth::user()->city->ct_id);;
        }if(Input::get('kood_id') <> '')
		{
			$response->where('kood_reqs.kood_id',Input::get('kood_id'));
		}
		if(Input::get('startDate') <> '')
		{
			$st = Input::get('startDate');
			$dt = explode('/', $st);
			
			$yearStart =  $dt[0];
			$monthStart = $dt[1];
			$dayStart = $dt[2];
			
			$start = \Morilog\Jalali\CalendarUtils::toGregorian($yearStart, $monthStart, $dayStart); // [2016, 5, 7]
			$startDate = $start[0].'-'.$start[1].'-'.$start[2];
			
			$response->whereDate('kood_reqs.make_date','>=',$startDate);
		}
		if(Input::get('endDate') <> '')
		{
			$st = Input::get('endDate');
			$dt = explode('/', $st);
			
			$yearEnd =  $dt[0];
			$monthEnd = $dt[1];
			$dayEnd = $dt[2];
			
			$end = \Morilog\Jalali\CalendarUtils::toGregorian($yearEnd, $monthEnd, $dayEnd); // [2016, 5, 7]
			$endDate = $end[0].'-'.$end[1].'-'.$end[2];
			
			$response->whereDate('kood_reqs.make_date','<=',$endDate);
		}
		
		$response = $response->get();
        // load the view and pass the samRequest
    	return view("admin.report.city_brokers")->with([
            "crumb" => $crumb,
			"response" => $response,
			'koods' => $koods,
			'fKood' => $fKood,
			"startDate" => Input::get('startDate'),
			"endDate" => Input::get('endDate'),
			"kood_id" => Input::get('kood_id')
        ]);
    }
	
	public function brokerCity(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker','managerJahad','nazer']);
		
		$id = $request->get('sendBroker');
		$kood = $request->get('sendKood');
		$sDate = $request->get('sendStartDate');
		$eDate = $request->get('sendEndDate');
		
        $brok = User::find($id);
		
		$crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        
        $crumb[1] = ['title'=>'گزارش شهرستان '.Auth::user()->city->title.' به تفکیک کارگزار','url'=>url("report/brokerCity"),'class'=>''];
		$crumb[2] = ['title'=>'گزارش کارگزار  '.$brok->name,'url'=>'','class'=>'active'];
		
		
		$response = KoodReq::select(DB::raw('tbl_products.title as title'),
								 DB::raw('sum(tbl_kood_reqs.value) as kise'),
								 DB::raw('sum(tbl_kood_reqs.value * 50 / 1000) as tone'),
								 DB::raw('sum(tbl_kood_reqs.price_all) as price'),
								 DB::raw('sum(tbl_kood_reqs.sath) as sathZirKesht'),
								 'users.name as name',
								 'users.mobile as mobile',
								 'users.id as id')
			->join('products','products.id','=','kood_reqs.kood_id')
			->join('users','users.id','=','kood_reqs.user_id')
			->where('kood_reqs.status','>',0)
			->where('kood_reqs.broker_id',$id)
			->orderBy('make_date','desc')
			->groupBy('kood_reqs.user_id');
	
		if(Auth::user()->hasRole('managerJahad'))
        {
            $response->where('kood_reqs..ct_id',Auth::user()->city->ct_id);;
        }
		
		if($kood <> '')
		{
			$response->where('kood_reqs.kood_id',$kood);
		}
		
		if($sDate <> '')
		{
			$st = $sDate;
			$dt = explode('/', $st);
			
			$yearStart =  $dt[0];
			$monthStart = $dt[1];
			$dayStart = $dt[2];
			
			$start = \Morilog\Jalali\CalendarUtils::toGregorian($yearStart, $monthStart, $dayStart); // [2016, 5, 7]
			$startDate = $start[0].'-'.$start[1].'-'.$start[2];
			
			$response->whereDate('kood_reqs.make_date','>=',$startDate);
		}
		if($eDate <> '')
		{
			$st = $eDate;
			$dt = explode('/', $st);
			
			$yearEnd =  $dt[0];
			$monthEnd = $dt[1];
			$dayEnd = $dt[2];
			
			$end = \Morilog\Jalali\CalendarUtils::toGregorian($yearEnd, $monthEnd, $dayEnd); // [2016, 5, 7]
			$endDate = $end[0].'-'.$end[1].'-'.$end[2];
			
			$response->whereDate('kood_reqs.make_date','<=',$endDate);
		}
		
		$response = $response->get();
		
    	return view("admin.report.userKoods")->with([
            "crumb" => $crumb,
			"response" => $response,
			"users" => [],
			"user_id" => 0,
			"startDate" => "",
			"endDate" => ""
        ]);
    }
	
	public function getUser(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker','managerJahad','nazer']);
		
    	// get all the user

		$crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'گزارش شهرستان','url'=>'','class'=>'active'];

        $btn = null;

		$gridQuery = KoodReq::join('products','products.id','=','kood_reqs.kood_id')
			->join('users','users.id','=','kood_reqs.user_id')
			->where('kood_reqs.status','>',0)
			->where('kood_reqs.ct_id',Auth::user()->city->ct_id)
			->orderBy('make_date','desc');
        $Grid = new Grid($gridQuery, 'kood_reqs');
    	
        $Grid->fields([
            'name'=>trans('validation.attributes.name'),
            'codemelli'=>trans('validation.attributes.codemelli'),
            'mobile'=>trans('validation.attributes.mobile'),
            'title'=>trans('validation.attributes.title'),
            'value'=>'مقدار (کیسه 50 کیلویی)',
            'price_all'=>'مبلغ ( ریال)',
        ])->actionFields([
            'tbl_kood_reqs.id' //The fields used for process actions. those not are showed 
        ]);
        
        
        
        // load the view and pass the user
    	return view("admin.user.all")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }
}
