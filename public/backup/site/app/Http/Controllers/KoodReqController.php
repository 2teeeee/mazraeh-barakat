<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\KoodReq;
use App\Models\HandyValue;
use App\Models\Product;
use App\Models\ProductKoodValue;
use App\Models\UserKesht;
use App\Models\RequestPay;
use App\Models\KargozarKoodValue;
use App\Models\RequestPayKood;
use App\Models\BrokerKood;
use App\Models\CityAverage;
use App\Models\ShotooiValue;
use App\Models\City;
use App\Models\BlockUser;
use App\Models\UserKeshtReq;
use App\Models\ManualSell;

use Cart;
use App\Helpers\Sms;
use App\Models\Location;
use Rafwell\Simplegrid\Grid;
use App\User;
use Image;
use Auth;

class KoodReqController extends Controller
{   
	public function __construct()
    {
		$this->middleware('auth');
    }
	
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','planter']);
        
    	$model = [];
        
    	$gridQuery = KoodReq::join('users','users.id','=','kood_reqs.user_id')
                ->join('products','products.id','=','kood_reqs.kood_id')
                ->join('products as pr','pr.id','=','kood_reqs.product_id')
                ->join('cities','cities.ct_id','=','kood_reqs.ct_id')
                ->where('kood_reqs.user_id',Auth::id())
                ->where('kood_reqs.status', '>', 0)
                ->orderBy('kood_reqs.make_date','desc');
        
        $Grid = new Grid($gridQuery, 'kood_reqs');
        $Grid->fields([
            'tbl_kood_reqs.code'=>trans('validation.attributes.code'),
            'tbl_users.name'=>trans('validation.attributes.name'),
            'date'=>[
                'label'=>trans('validation.attributes.date'),
                'field'=>"tbl_kood_reqs.make_date"
            ],
            'prod'=>[
                'label'=>'محصول کشت شده',
                'field'=>"tbl_pr.title"
            ],
            'city'=>[
                'label'=>'شهرستان',
                'field'=>"tbl_cities.title"
            ],
            'tbl_products.title'=>trans('validation.attributes.kood_id'),
            'tbl_kood_reqs.value'=>trans('validation.attributes.value'),
            'tbl_kood_reqs.status'=>'وضعیت درخواست',
          
        ])->actionFields([
            'tbl_kood_reqs.id',
            'tbl_kood_reqs.status'
        ])->processLine(function($row){
            //This function will be called for each row
            
            $row['status'] = ($row['status'] == 1)?"در انتظار تحویل":"تحویل داده شده";
            $row['date'] = jdate($row['date'])->format("Y/m/d");
            //Do more you need on this row
            return $row; //Do not forget to return the row
        });
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view');
        
        // load the view and pass the samRequest
    	return view("admin.request.koodReq.list")->with([
        //    "model"=>$model,
//            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }
    
    public function view($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','planter']);
    
        $model = KoodReq::find($id);
        
        return view("admin.request.koodReq.view")->with([
            "model"=>$model
        ]);
        
    }
    
    public function create($id,Request $request)
    {       
     //   return Redirect::to('lock.html');
        $request->user()->authorizeRoles(['admin','manager','programmer','planter','nazer']);
        
		$block = BlockUser::where('codemelli',Auth::user()->codemelli)->first();
		if($block != null)
        {
            return view("home.lock_kood")->with([
            ]);
        }
		
        $sendType = HandyValue::where('handy_id',19)->get();
        $koods = Product::where('category_id',3)->get();
        
        $kesht = UserKesht::find($id);
        
        $pkv = ProductKoodValue::where('productCode_id',$kesht->product->code)
                        ->where('abType_id',$kesht->abType_id)
                        ->where('ct_id',$kesht->ct_id)
                        ->whereDate('startDate', '<=', date('Y-m-d'))
                        ->whereDate('endDate', '>=', date('Y-m-d'))
                        ->first();
        if($pkv == null)
        {
            return view("home.lock")->with([
                'city' => $kesht->ct->title,
                'product' => $kesht->product->title,
                'ab' => $kesht->ab->title
            ]);
        }
        
        $brokers = [];
        if($kesht->ct)
        {
            $brokers = User::join('role_user','users.id','=','role_user.user_id')
                ->where('role_user.role_id',11)
                ->where('users.city_id',$kesht->ct->id)
                ->get();
        }
            
        $ProductSquare = Auth::user()->keshtProduct($kesht->product_id,$kesht->abType_id,$kesht->ct_id)->sum;

		$maxValue = $ProductSquare * 8500;

		$shotValue = ShotooiValue::where('user_id',Auth::id())->where('product_id',$kesht->product_id)->where('city_id',$kesht->ct->id)->sum('value');
		
		$maxShot = $shotValue;
		if($shotValue > $maxValue)
			$shotValue = $maxValue;
		
        // load the create form (app/views/samRequest/create.blade.php)
        return view("admin.request.koodReq.create")->with([
            'sendType' => $sendType,
            'koods' => $koods,
            'zaminkesht' => $kesht,
            'brokers' => $brokers,
            'ProductSquare' => $ProductSquare,
			'shotValue' => $shotValue,
			'maxShot' => $maxShot,
			'pkv' => $pkv
        ]);
    }
    
    public function store(Request $request)
    {
        $prod = Input::get('prod_id');
        $keshtId = Input::get('kesht_id');

        $rules = array(
            'kood_id' => ['required'],
            'sendType' => ['required'],
            'broker_id' => ['required'],
            'check_zamin' => ['required'],
        //    'numb' => ['required','min:1']
        );
        $validator = Validator::make(Input::all(), $rules);
        
        // process the login
        if ($validator->fails()) {
            return Redirect::to('koodReq/create/'.$keshtId)
                ->withErrors($validator)->withInput();
        } else {
            
            $address = Input::get('address');
            // store
            $koodId = Input::get('kood_id');
            $send = Input::get('sendType');
            $brokerId = Input::get('broker_id');
      //      $numbReq = Input::get('numb');
            
            $kood = Product::find($koodId);
            $sendType = HandyValue::find($send);
            $prodFind = Product::find($prod);
            $kesht = UserKesht::where('user_id',Auth::id())->where('id',$keshtId)->first();
            $broker = User::find($brokerId);

            if($send == 165)
            {
                $rules = array(
                    'address' => ['required'],
                );
                $validator = Validator::make(Input::all(), $rules);

                // process the login
                if ($validator->fails()) {
                    return Redirect::to('koodReq/create/'.$keshtId)
                        ->withErrors($validator)->withInput();
                }
            }
            
            foreach(Cart::getContent() as $item):
                $productCheck = $item->attributes->req->product_id;
                $koodCheck = $item->attributes->req->kood_id;
                $ct_id = $item->attributes->req->ct_id;
                $abType_id = $item->attributes->req->abType_id;
               
                if(($productCheck == $prod) and ($koodCheck == $koodId) and ($ct_id == $kesht->ct_id) and ($abType_id == $kesht->abType_id))
                {
//                    Cart::update($item->id, array(
//                        'quantity' => array(
//                            'relative' => false,
//                            'value' => $numbReq
//                        ), 
//                    ));
//                    
//                    $up = KoodReq::find($item->id);
//                    $up->value = $numbReq;
//                    $up->save();
                    
                    Session::flash('error', trans('برای محصول '.$item->attributes->req->product->title.' درخواست کود '.$item->attributes->req->kood->title.' را قبلا ثبت کرده اید.'));
                    return Redirect::to('koodReq/cart');
                }
            
            endforeach;
            
            $zaminSize = 0;
			$shotValue = 0;
			
            $pkv = null;
            if($kesht)
            {

                $zaminSize = Auth::user()->keshtProduct($kesht->product_id,$kesht->abType_id,$kesht->ct_id)->sum;

                if($kood)
                {
                    $getKood = KoodReq::join('products', 'products.id', '=', 'kood_reqs.kood_id')
                        ->where('kood_reqs.product_id',$kesht->product_id)
                        ->where('kood_reqs.abType_id',$kesht->abType_id)
                        ->where('kood_reqs.ct_id',$kesht->ct_id)
                        ->where('products.koodType_id',$kood->koodType_id)
                        ->where('status','>',0)
                        ->where('type',0)
						->where('user_id',Auth::id())
                        ->sum('kood_reqs.value');

					$manualSell = ManualSell::where('codemelli',Auth::user()->codemelli)->where('city_id',$kesht->ct->id)->sum('value');

					$getKood = $getKood + $manualSell;
					
                    $pkv = ProductKoodValue::where('productCode_id',$prodFind->code)
                        ->where('koodType_id',$kood->koodType_id)
                        ->where('abType_id',$kesht->abType_id)
                        ->where('ct_id',$kesht->ct_id)
                        ->whereDate('startDate', '<=', date('Y-m-d'))
                        ->whereDate('endDate', '>=', date('Y-m-d'))
                        ->first();
                }
				$shotValue = ShotooiValue::where('user_id',Auth::id())->where('product_id',$prod)->where('city_id',$kesht->ct->id)->sum('value');

            }


          //  $prodValue = $pkv?($pkv->value / $kood->bagValue):0;

          //  $numb = round($prodValue?($prodValue * $zaminSize):0);
            
			
			$maxValue = $zaminSize * 8500;

			$shotValue = ShotooiValue::where('user_id',Auth::id())->where('product_id',$prod)->where('city_id',$kesht->ct->id)->sum('value');

			if($shotValue > $maxValue)
				$shotValue = $maxValue;
			elseif($shotValue <= ($maxValue / 2))
				$shotValue = ($pkv->value * 13) * $zaminSize;
		
			
			$city = City::where('ct_id',$kesht->ct_id)->first();
			$cityAverage = $city?CityAverage::where('city_id',$city->id)->first():0;
			$average = $cityAverage?$cityAverage->average:0;
			if($pkv)
			{
				$maxValue = ($pkv->value / 50) * $zaminSize;
			
				$kil = $shotValue / 13;
				$kilValue = $kil / $kood->bagValue;

				if($pkv->productCode_id == 102)
				{
					if($shotValue > 0)
					{
						//	$prodValue = ($kilValue >= $maxValue)?$maxValue:($maxValue - $kilValue);
						// $prodValue = $kilValue  * 30 / 100;
						$prodValue = $kilValue;
						$numb = round($prodValue) - $getKood;
					}
					else
					{
						$prodValue = round($zaminSize);
						$numb = round($zaminSize) - $getKood;
					}
				}
				else
				{
					$prodValue = $maxValue;
					$numb = round($prodValue) - $getKood;
				}
				
			}
			else
			{
				$prodValue = 0;
				$numb = 0;
			}
			
			$numbReq = $numb;
       //     $numb = $numbReq;
       //     $remKood = $numb - $getKood;

//            if($numbReq > $remKood)
//            {
//                $numbReq = $remKood;
//                $numbText = 'حداکثر تعداد کود درخواستی می تواند '.$numbReq.' کیسه باشد.';
//            }
//            elseif($numbReq < 1)
//            {
//                $numbReq = 1;
//                $numbText = 'حداقل تعداد کود درخواستی می تواند '.$numbReq.' کیسه باشد.';
//            }
//            else
//                $numbText = '';

            $brokerValue = $broker?$broker->koodValBag($koodId):0;
            
            
            $checkBroker = ($numbReq <= ($broker?$broker->koodValBag($koodId):0) and $numbReq > 0)?true:false;

            $prodPrice = $kood?$kood->price:0;
            $total = $numbReq * $prodPrice;

            $sendTypeVal = 0;
            $total = $total?($total + $sendTypeVal):0;
        
            if($numbReq > 0)
            {
                if($checkBroker)
                {
                    $code = rand(111111111,999999999);
                    while (KoodReq::where('code',$code)->first()) {
                        $code = rand(111111111,999999999);
                    }

                    $model = new KoodReq;
                    $model->user_id = Auth::id();
                    $model->kood_id = $koodId;
                    $model->value = $numbReq;
                    $model->price_product = $prodPrice;
                    $model->price_all = $total;
                    $model->statusPay = 0;
                    $model->status = 0;
                    $model->send_value = $sendTypeVal;
                    $model->send_id = $send;
                    $model->kesht_id = $kesht->id;
                    $model->address = $address;
                    $model->broker_id = $brokerId;
                    $model->code = $code;
                    $model->product_id = $kesht->product_id;
                    $model->ct_id = $kesht->ct_id;
                    $model->abType_id = $kesht->abType_id;
					$model->make_date = date("Y-m-d");
					$model->sath = $kesht->square;
					$model->type = 0;
                    $model->save();
                    // redirect
                //    Session::flash('message', trans('درخواست شما با موفقیت ثبت شد.'));


                    
                 //   $prod = Prod::where('id',$id)->first();
                    Cart::add($model->id, $model->kood->title, $prodPrice, $numbReq, array('req'=>$model));
                    Session::flash('success', 'درخواست شما با موفقیت ثبت شد. برای ثبت نهایی درخواست بر روی ثبت نهایی درخواست کلیک کنید.');
                    return Redirect::to('koodReq/cart');
                    
                }
                else
                {
                    Session::flash('error', 'کارگزار انتخابی شما برای کود مورد نظرتان موجودی کافی ندارد. لطفا کارگزار دیگری انتخاب کنید.');
                    return Redirect::to('koodReq/create/'.$keshtId);
                }
            }
            else
            {
                Session::flash('error', 'کود درخواستی قبلا ثبت شده است و یا کارگزار انتخابی موجودی کافی برای ارائه کود مورد نظر را ندارد.');
                return Redirect::to('koodReq/create/'.$keshtId);
            }  
        }
    }
    
    public function checkKood()
    {
        $koodId = Input::get('id');
        $send = Input::get('send');
        $prod = Input::get('prod');
        $keshtId = Input::get('kesht');
        $broker = Input::get('broker');
       // $numbReq = Input::get('numbReq');
        
        $kood = Product::find($koodId);
        $sendType = HandyValue::find($send);
        $prodFind = Product::find($prod);
        $kesht = UserKesht::where('user_id',Auth::id())->where('id',$keshtId)->first();
        $broker = User::find($broker);
    //    $numbReq = $numbReq?$numbReq:0;
		

        $brokerValue = $broker?$broker->koodValBag($koodId):0;
		$shotValue = 0;
        
        $zaminSize = 0;
        $koodReqVal = 0;

        $pkv = null;
		
        if($kesht)
        {
            $zaminSize = Auth::user()->keshtProduct($kesht->product_id,$kesht->abType_id,$kesht->ct_id)->sum;
            if($kood)
            {
                $getKood = KoodReq::join('products', 'products.id', '=', 'kood_reqs.kood_id')
                    ->where('kood_reqs.product_id',$kesht->product_id)
                    ->where('kood_reqs.abType_id',$kesht->abType_id)
                    ->where('kood_reqs.ct_id',$kesht->ct_id)
                    ->where('products.koodType_id',$kood->koodType_id)
                    ->where('status','>',0)
					->where('type',0)
					->where('user_id',Auth::id())
                    ->sum('kood_reqs.value');
				
				$manualSell = ManualSell::where('codemelli',Auth::user()->codemelli)->where('city_id',$kesht->ct->id)->sum('value');
				
				$getKood = $getKood + $manualSell;

                $pkv = ProductKoodValue::where('productCode_id',$prodFind->code)
                    ->where('koodType_id',$kood->koodType_id)
                    ->where('abType_id',$kesht->abType_id)
                    ->where('ct_id',$kesht->ct_id)
                    ->whereDate('startDate', '<=', date("Y-m-d"))
                    ->whereDate('endDate', '>=', date("Y-m-d"))
                    ->first();
            }
			
			$shotValue = ShotooiValue::where('user_id',Auth::id())->where('product_id',$prod)->where('city_id',$kesht->ct->id)->sum('value');
        }
		
			
		$maxValue = $zaminSize * 8500;
        
		if($shotValue > $maxValue)
			$shotValue = $maxValue;
		elseif($shotValue <= ($maxValue / 2))
			$shotValue = ($pkv->value * 13) * $zaminSize;
		
		$city = City::where('ct_id',$kesht->ct_id)->first();
		$cityAverage = $city?CityAverage::where('city_id',$city->id)->first():0;
		$average = $cityAverage?$cityAverage->average:0;
		
		if($pkv)
		{
			$maxValue = ($pkv->value / 50) * $zaminSize;
			
			$kil = $shotValue / 13;
			$kilValue = $kil / $kood->bagValue;
			
			if($pkv->productCode_id == 102)
			{
				if($shotValue > 0)
				{
				//	$prodValue = ($kilValue >= $maxValue)?$maxValue:($maxValue - $kilValue);
				//	$prodValue = $kilValue  * 30 / 100;
					$prodValue = $kilValue;
					$numb = round($prodValue) - $getKood;
				}
				else
				{
					$prodValue = round($zaminSize);
					$numb = round($zaminSize) - $getKood;
				}
			}
			else
			{
				$prodValue = $maxValue;
				$numb = round($prodValue) - $getKood;
			}
		}
		else
		{
			$prodValue = 0;
			$numb = 0;
		}
        	
		
//        $remKood = $numb - $getKood;
//        
//        if($numbReq > $remKood)
//        {
//            $numbReq = $remKood;
//            $numbText = 'حداکثر تعداد کود درخواستی می تواند '.$numbReq.' کیسه باشد.';
//        }
//        elseif($numbReq < 1)
//        {
//            // $numbReq = 1;
//            $numbText = 'حداقل تعداد کود درخواستی می تواند '.$numbReq.' کیسه باشد.';
//        }
//        else
//            $numbText = '';

      //  $numbReq = $numbReq?$numbReq:$remKood;
        $numbReq = $numb;
        $checkBroker = ($numbReq <= $brokerValue and $numbReq > 0)?1:0;
            
        $prodPrice = $kood?$kood->price:0;
        $total = $numbReq * $prodPrice;
        
        $sendTypeVal = 0;
        
        $total = $total?($total + $sendTypeVal):0;

        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
        
    //    $btn = ($numb and ($getKood == 0))?"1":"0";
    //   $rem = $numbReq;
		
        $num = range(0, 9);
		$numb = ($numb > 0)?$numb:0;
        $numb = str_replace($num,$persian, $numb);
        $zaminSize = str_replace($num,$persian, $zaminSize);
     //   $getKood = str_replace($num,$persian, $getKood);
     //   $remKood = str_replace($num,$persian, $remKood);
        $numbReq = str_replace($num,$persian, $numbReq);
     //   $numbText = str_replace($num,$persian, $numbText);
        $item = str_replace($num,$persian, number_format($prodPrice));
        $sendTypeVal = ($sendType->id == 165)?"توافقی با کارگزار":str_replace($num,$persian, number_format(0)).' ریال';
        $total = str_replace($num,$persian, number_format($total));
        
        return [
            'squere' => $zaminSize,
            'num' => $numb,
            'totalPrice' => $total,
            'itemPrice' => $item,
            'sendVal' => $sendTypeVal,
            'btnStatus' => "1",
            'checkBroker' => $checkBroker,
         //   'getKood' => $getKood,
         //   'remKood' => $remKood,
         //   'numbReq' => $numbReq,
         //   'numbText' => $numbText,
         //   'rem' => $rem
        ];
    }
    
    public function cart()
    {
		$credit = Auth::user()->mainBag()->credit();
		
        return View('admin.request.koodReq.cart')->with([
			'credit' => 0
		]);
    }
    
    public function removeCard($id)
    {
        Cart::remove($id);
        $model = KoodReq::find($id);
        $model->delete();
        return back();
    }
	
    public function endSale(Request $request)
    {       
     //   return Redirect::to('lock.html');
        $request->user()->authorizeRoles(['admin','manager','programmer','planter']);
        
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
//        $rules = array(
//            'dargah' => 'required',
//            'name' => 'required',
//            'mobile' => 'required',
//            'address' => 'required'
//        );
//        $validator = Validator::make(Input::all(), $rules);
//        if ($validator->fails()) {
//            return Redirect::to('prod/cart')
//                ->withErrors($validator)->withInput();
//        }
        
        
        $reqPay = new RequestPay;
     //   $reqPay->request_id = $model->id;
        $reqPay->req_type = 1;
        $reqPay->status = 0;
        $reqPay->save();

        $total = 0;
        foreach(Cart::getContent() as $item):
            $reqPayKood = new RequestPayKood();
            $reqPayKood->request_pay_id = $reqPay->id;
            $reqPayKood->kood_request_id = $item->id;
            $reqPayKood->save();
            
            $total = $total + (($item->price * $item->quantity) + $item->attributes->req->send->value);
       	endforeach;
		
		$reqPay->price = $total;
		$reqPay->save();

		Cart::clear();

		return Redirect::to('sep/'.$reqPay->id);  
        
    //    return View('admin.request.koodReq.verify');
    }
	
	public function ezhar($id,Request $request)
    {       
        
        $model = ProductKoodValue::find($id);
        
        // load the create form (app/views/samRequest/create.blade.php)
        return view("admin.request.userReq.ezhar")->with([
            'model' => $model,
        ]);
    }
    
    public function ezharPost($id,Request $request)
    {
        $rules = array(
            'value' => ['required','numeric','max:10'],
            'abType_id' => ['required'],
        );
        $validator = Validator::make(Input::all(), $rules);
        
        // process the login
        if ($validator->fails()) {
            return Redirect::to('userReq/Declarative/'.$id)
                ->withErrors($validator)->withInput();
        } else {
            $pkv = ProductKoodValue::find($id);
			
            $value = Input::get('value');
            
			$model = new UserKeshtReq;
			$model->user_id = Auth::id();
			$model->product_id = $pkv->product->id; 
			$model->kood_id = $pkv->kood->id;
			$model->city_id = Auth::user()->city_id;
			$model->zaminSize = $value;
			$model->abType_id = Input::get('abType_id');
			$model->rdate = date("Y-m-d H:i:s");
			$model->status = 0;
			$model->name = Auth::user()->name;
			$model->father = Auth::user()->father_name;
			$model->codemelli = Auth::user()->codemelli;
			$model->roosta = Auth::user()->address;
			$model->mobile = Auth::user()->mobile;
			$model->save();
            
			return Redirect::to('userReq/pay/'.$model->id);
            
        }
    }
	
	public function ezharPay($id,Request $request)
    {       
        
        $model = UserKeshtReq::find($id);
		
		$brokers = User::join('role_user','users.id','=','role_user.user_id')
			->where('role_user.role_id',11)
			->where('users.city_id',$model->city_id)
			->get();
		$activeBroker = [];
		foreach($brokers as $broker)
		{
			$us = User::find($broker->user_id);
			if($us->koodValBag($model->kood_id) > ($model->zaminSize * 2))
			{
				
				$activeBroker[$us->id] = $us->name.' ('.$us->company.')';
			}
		}
		
        // load the create form (app/views/samRequest/create.blade.php)
        return view("admin.request.userReq.ezhar_pay")->with([
            'model' => $model,
			'activeBroker' => $activeBroker
        ]);
    }
	
	public function ezharPayEnd($id,Request $request)
    {
        $rules = array(
            'broker_id' => ['required'],
        );
        $validator = Validator::make(Input::all(), $rules);
        
        // process the login
        if ($validator->fails()) {
            return Redirect::to('userReq/pay/'.$id)
                ->withErrors($validator)->withInput();
        } else {
			$model = UserKeshtReq::find($id);
			$model->broker_id = Input::get('broker_id');
			$model->save();
			
			
			$code = rand(111111111,999999999);
			while (KoodReq::where('code',$code)->first()) {
				$code = rand(111111111,999999999);
			}

			$koodReq = new KoodReq;
			$koodReq->user_id = Auth::id();
			$koodReq->kood_id = $model->kood_id;
			$koodReq->value = $model->zaminSize * 1;
			$koodReq->price_product = $model->kood->price;
			$koodReq->price_all = $model->zaminSize * 1 * $model->kood->price;
			$koodReq->statusPay = 0;
			$koodReq->status = 0;
			$koodReq->send_value = 0;
			$koodReq->send_id = 0;
			$koodReq->kesht_id = '';
			$koodReq->address = $model->roosta;
			$koodReq->broker_id = $model->broker_id;
			$koodReq->code = $code;
			$koodReq->product_id = $model->product_id;
			$koodReq->ct_id = $model->city->ct_id;
			$koodReq->abType_id = 6;
			$koodReq->make_date = date("Y-m-d");
			$koodReq->sath = $model->zaminSize;
			$koodReq->type = 0;
			$koodReq->user_zamin_req_id = $model->id;
			$koodReq->save();
			
            $reqPay = new RequestPay;
			$reqPay->req_type = 1;
			$reqPay->status = 0;
			$reqPay->save();

			$total = 0;
			
			$reqPayKood = new RequestPayKood();
			$reqPayKood->request_pay_id = $reqPay->id;
			$reqPayKood->kood_request_id = $koodReq->id;
			$reqPayKood->save();
			
			$reqPay->price = $koodReq->price_all;
			$reqPay->save();
			Cart::clear();

			return Redirect::to('sep/'.$reqPay->id);  
            
        }
    }
}
