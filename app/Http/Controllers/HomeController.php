<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prod;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Rules\CheckResetPassword;
use App\Rules\CheckForMobile;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Sms;
use App\Models\City;
use App\Models\Bakhsh;
use App\Models\Pahne;
use App\Models\Bahre;
use App\Models\Role;
use App\Models\Bag;
use App\Models\Contact;
use App\Models\UserKesht;
use App\Models\Product;
use App\Models\KoodReq;
use App\Models\BrokerKood;
use App\Models\ShotooiValue;
use App\Models\Payment;
use App\Models\BagPay;
use App\Models\RequestPay;


use App\Models\Bl;

use App\Models\Check;

use PDF;
use Auth;
use App\User;

use Morilog\Jalali\Jalalian;

use nusoap_client;

use App\Helpers\Jahad;

use App\Models\UserInfo;
use App\Models\ListBahre;

use Illuminate\Support\Facades\Hash;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
         $this->middleware('check.info.user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
public function testLang()
{
    return view('lan');
}

    public function test()
    {
		$mods = KoodReq::groupBy('broker_id')->get();
		
		foreach($mods as $mod)
		{
			echo $mod->broker->codemelli.',',"<br/>";
		}

    }
    
    public function index() {

        
        $model = Prod::all();

        return view('home.index')->with(['model' => $model]);
    }
	
    public function lock() {
        return view('home.lock');
    }

    public function login()
    {
        
        return view('auth.login');
    }
    
    public function checkLogin()
    {
        $rules = array(
            "uname" => 'required',
            "password" => 'required',
            "captcha" => 'required|captcha'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('login.html')
                ->withErrors($validator)->withInput();
        } else {
            $cmelli = Input::get('uname');
            $mob = Input::get('password');
            $user = User::where('uname',$cmelli)->first();

            $response = Jahad::GetPahneFarmInfo($cmelli);
            if($user == null)
            {
                if($response['GetPahneFarmInfoResult']['errCode'] == 0)
                {
                    if(isset($response['GetPahneFarmInfoResult']['CodeMeli']))
                    {
                        $cmeli = $response['GetPahneFarmInfoResult']['CodeMeli'];
                        $mobile = $response['GetPahneFarmInfoResult']['Mobile'];

                        if(($cmelli == $cmeli) and ($mob == $mobile))
                        {
                            $user = User::where('codemelli',$cmeli)->where('mobile',$mobile)->first();
                            if($user == null)
                            {
                                $user = new User;
                                $user->name = $response['GetPahneFarmInfoResult']['Name']." ".$response['GetPahneFarmInfoResult']['LastName'];
                                $user->uname = $response['GetPahneFarmInfoResult']['CodeMeli'];
                                $user->codemelli = $response['GetPahneFarmInfoResult']['CodeMeli'];
                                $user->password = Hash::make($mob);
                                $user->mobile = $mob;
                                $user->check_email = 0;
                                $user->check_mobile = 0;
                                $user->father_name = $response['GetPahneFarmInfoResult']['FatherName'];
                                $user->status = 0;
                                $user->code = time();
                                $user->save();

                                $user
                                    ->roles()
                                    ->attach(Role::where('name', 'planter')->first());


                                $bag = new Bag;
                                $bag->user_id = $user->id;
                                $bag->status = 1;
                                $bag->isMain = 1;
                                $bag->title = 'کیف اصلی '.$user->code;
                                $bag->save();

                                $mob = $user->mobile;

                                

                                Sms::sendSMS('از ثبت نام شما در اپلیکیشن مزرعه سپاسگذاریم.','+9810000002020',"$mob");
                            }
                        }
                    }
                }
                else
                {
                    return view('profile.unvalid_info')->with([
                        'message' => 'نام کاربری  و کلمه ی عبور شما با اطلاعات درج شده در سامانه جهاد کشاورزی مطابقت ندارد. لطفا جهت بررسی و اصلاح اطلاعات به جهاد کشاورزی منطقه خود مراجعه کنید.'
                    ]);
                }
            }
            else
            {
				
                if($response['GetPahneFarmInfoResult']['errCode'] == 0)
                {
                    if(isset($response['GetPahneFarmInfoResult']['CodeMeli']))
                    {
                        $cmeli = $response['GetPahneFarmInfoResult']['CodeMeli'];
                        $mobile = $response['GetPahneFarmInfoResult']['Mobile'];

                        if(($cmelli == $cmeli) and ($mob == $mobile))
                        {
                            $user->name = $response['GetPahneFarmInfoResult']['Name']." ".$response['GetPahneFarmInfoResult']['LastName'];
                            $user->uname = $response['GetPahneFarmInfoResult']['CodeMeli'];
                            $user->mobile = $mob;
                            $user->check_email = 0;
                            $user->check_mobile = 0;
                            $user->father_name = $response['GetPahneFarmInfoResult']['FatherName'];
                        
                            $user->save();
                        }
                    }
                }
				
            }
				
			UserKesht::where('user_id',$user->id)->delete();

            if(isset($response['GetPahneFarmInfoResult']['Products']))
                {
                    if($response['GetPahneFarmInfoResult']['Products'] != null){
                        foreach($response['GetPahneFarmInfoResult']['Products']['Product'] as $key => $prod)
                        {
                            
                            if(!is_numeric($key)): 
                                $prod2 = $response['GetPahneFarmInfoResult']['Products']['Product'];

                                if($prod2['AgriType'] == 1)
                                    $nid = 6;
                                else
                                    $nid = 7;

                                $pr = Product::where('code',$prod2['productCode'])->first();
                                $ukesht = UserKesht::where('user_id',$user->id)
                                        ->where('product_id',$pr?$pr->id:'')
                                        ->where('abType_id',$nid)
                                        ->where('keshtDate','98-99')
                                        ->where('agri_id',$prod2['Agri_id'])
                                        ->where('ct_id',$prod2['ct_id'])
                                        ->first();
                                if($ukesht == null){
                                    $newProd = new UserKesht();
                                    $newProd->user_id = $user->id;
                                    $newProd->product_id = $pr?$pr->id:'';
                                    $newProd->square = $prod2['Square'];
                                    $newProd->agri_id = $prod2['Agri_id'];
                                    $newProd->ct_id = $prod2['ct_id'];
                                    $newProd->abType_id = $nid;
                                    $newProd->keshtDate = '98-99';
                                    $newProd->m_name = $prod2['name']." ".$prod2['last_name'];
                                    $newProd->m_codem = $prod2['mor_cod_m'];
                                    $newProd->m_mobile = $prod2['tel_m'];
                                    $newProd->save();
									
                                }
                                else
                                {
                                    $ukesht->square = $prod2['Square'];
                                    $ukesht->m_name = $prod2['name']." ".$prod2['last_name'];
                                    $ukesht->m_codem = $prod2['mor_cod_m'];
                                    $ukesht->m_mobile = $prod2['tel_m'];
                                    $ukesht->save();
                                }

                                break;
                            else:
                                if($prod['AgriType'] == 1)
                                    $nid = 6;
                                else
                                    $nid = 7;

                                $pr = Product::where('code',$prod['productCode'])->first();
                                
                                $ukesht = UserKesht::where('user_id',$user->id)
                                        ->where('product_id',$pr?$pr->id:'')
                                        ->where('abType_id',$nid)
                                        ->where('keshtDate','98-99')
                                        ->where('agri_id',$prod['Agri_id'])
                                        ->where('ct_id',$prod['ct_id'])
                                        ->first();       
                                if($ukesht == null){
                                    $newProd = new UserKesht();
                                    $newProd->user_id = $user->id;
                                    $newProd->product_id = $pr?$pr->id:'';
                                    $newProd->square = $prod['Square'];
                                    $newProd->agri_id = $prod['Agri_id'];
                                    $newProd->ct_id = $prod['ct_id'];
                                    $newProd->abType_id = $nid;
                                    $newProd->keshtDate = '98-99';
                                    $newProd->m_name = $prod['name']." ".$prod['last_name'];
                                    $newProd->m_codem = $prod['mor_cod_m'];
                                    $newProd->m_mobile = $prod['tel_m'];
                                    $newProd->save();
                                }
                                else
                                {
                                    $ukesht->square = $prod['Square'];
                                    $newProd->m_name = $prod['name']." ".$prod['last_name'];
                                    $newProd->m_codem = $prod['mor_cod_m'];
                                    $newProd->m_mobile = $prod['tel_m'];
                                    $ukesht->save();
                                }
                            endif;
                            
                        }
                    }
                }

            if (!Hash::check($mob, $user->password))
                 $user = null;
            
            if($user)
            {
				$shotooi = ShotooiValue::where('codemelli',$user->codemelli)->whereNull('user_id')->update(array('user_id' => $user->id));
				
                Auth::login($user);
                Session::flash('success', $user->name.' گرامی به سامانه مزرعه برکت خوش آمدید.');
                return Redirect::to('profile/index.html');
            }
            else
            {
                return view('profile.unvalid_info')->with([
                    'message' => 'نام کاربری  و کلمه ی عبور شما با اطلاعات درج شده در سامانه جهاد کشاورزی مطابقت ندارد. لطفا جهت بررسی و اصلاح اطلاعات به جهاد کشاورزی منطقه خود مراجعه کنید.'
                ]);
            }
        
        }
        
        
    }
    
    
    
    public function changeOstan() {
        $id = Input::get('id');
        $citys = City::where('ostan_id', $id)->get();
        echo '<option disabled selected value> -- شهر مورد نظر را انتخاب کنید -- </option>';
        foreach ($citys as $city)
            echo '<option value="' . $city->id . '">' . $city->title . '</option>';
    }

    public function alertc($id) {
        Session::flash('message', 'درخواست با موفقیت ثبت شد.');
        return Redirect::to('samRequest/' . $id . '/userClinic');
    }
    
    public function Pahne()
    {
        $city = Bahre::where('id','>',175881)->get();
        
        foreach ($city as $value) {
            $user = User::where('codemelli',$value->codem)->first();
            if($user == null)
            {
                $mob = '0'.$value->mobile;
                $new = User::create([
                    'name' => $value->name.' '.$value->family,
                    'uname' => $value->codem,
                    'codemelli' => $value->codem,
                    'email' => '',
                    'mobile' => $mob,
                    'city_id' => $value->city,
                    'num_pahne' => $value->no_pahne,
                    'password' => Hash::make($mob),
                    'status' => 0,
                    'code' => time().rand(11111,99999),
                ]);
                $new->roles()->attach(Role::where('name', 'employee')->first());
            }
        }
        
       
    }
    
    public function getBag()
    {
        $users = User::all();
        
        foreach($users as $user)
        {
            $bag = Bag::where('user_id',$user->id)->first();
            if($bag == null):
                $bag = new Bag;
                $bag->user_id = $user->id;
                $bag->status = 1;
                $bag->isMain = 1;
                $bag->title = 'کیف اصلی '.$user->id;
                $bag->save();
            endif;
        }
        
    }
    
    public function terms()
    {
        return view('home.terms')->with([]);
    }
    
    public function about()
    {
        return view('home.about')->with([]);
    }
    
    public function faq()
    {
        return view('home.faq')->with([]);
    }
    
    public function contact()
    {
        return view('home.contact')->with([]);
    }

    public function contactSend()
    {
        $rules = array(
            "name" => 'required',
            "email" => 'nullable|email',
            "phone" => 'required',
            "subject" => 'required',
            "message" => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('contact.html')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new Contact;
            $model->name = Input::get('name');
            $model->status = 0;
            $model->email = Input::get('email');
            $model->phone = Input::get('phone');
            $model->subject = Input::get('subject');
            $model->message = Input::get('message');
            
            $model->save();
            
            Session::flash('message', trans('validation.attributes.success_save_message'));
            return Redirect::to('contact.html');
        }
    }
    
    public function generatePDF()
    {
        return PDF::loadFile(public_path())->save('/my_stored_file.pdf')->stream('download.pdf');

    }
    
    public function resetPasswordForm()
    {
        return view('home.reset_password');
    }
    
    public function resetPassword(Request $request)
    {
        $rules = array(
            'codemelli' => ['required'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('resetPassword.html')
                ->withErrors($validator)->withInput();
        } else {
            // store
            // $model = User::where('mobile',Input::get('mobile'))->first();
            // $model->codeReset = rand(11111111, 99999999);
            // $model->save();
            

            $cmelli = Input::get("codemelli");
            $response = Jahad::GetPahneFarmInfo($cmelli);
            
            if($response['GetPahneFarmInfoResult']['errCode'] == 0)
            {
                if(isset($response['GetPahneFarmInfoResult']['CodeMeli']))
                {
                    $cmeli = $response['GetPahneFarmInfoResult']['CodeMeli'];
                    $mobile = $response['GetPahneFarmInfoResult']['Mobile'];

                    
                    $user = User::where('codemelli',$cmeli)->first();
                    if($user != null)
                    {
                        $user->password = Hash::make($mobile);
                        $user->mobile = $mobile;
                        $user->save();

                    }
                    else
                    {
                        Session::flash('error', 'کد ملی وارد شده در سیستم وجود ندارد.');
                        return Redirect::to('resetPassword.html')->withInput();
                    }
                    
                }
            }
            else{
                Session::flash('error', 'کد ملی وارد شده در سیستم وجود ندارد.');
                return Redirect::to('resetPassword.html')->withInput();
            }

            Session::flash('message', 'کلمه عبور شما با موفقیت اصلاح شد. می توانید با کد ملی خود وموبایل وارد شده در سامانه پهنه وارد سامانه بشوید.');
            return Redirect::to('login');
        }
    }
    
    public function resetPasswordSend()
    {
        return view('home.reset_password_check');
    }
    
    public function resetPasswordComplate(Request $request)
    {
        $rules = array(
            'resetCode' => ['required', new CheckResetPassword],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('resetPasswordComplate.html')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = User::where('codeReset',Input::get('resetCode'))->first();
            $model->codeReset = '';
            $model->save();
            
            Session::put('resetUser', $model->id);
            
            Session::flash('message', trans('validation.attributes.InputNewPassword'));
            return Redirect::to('newPassword.html');
        }
    }
    
    public function newPasswordForm()
    {
        return view('home.new_password');
    }
    
    public function newPassword(Request $request)
    {
        $rules = array(
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('resetPasswordComplate.html')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $user = session('resetUser');
            $model = User::find($user);
            $model->password = Hash::make(Input::get('password'));
            $model->save();
            
            Auth::login($model);

            return Redirect::to('index.html');
        }
    }
    
    public function sendUser()
    {
        $model = ListBahre::all();
        foreach($model as $bahre)
        {
            $check = User::where('codemelli',$bahre->codem)->first();
            if($check == null)
            {
                $new = new User;
                $new->name = $bahre->name." ".$bahre->family;
                $new->num_pahne = $bahre->no_pahne;
                $new->sex = $bahre->sex;
                $new->codemelli = $bahre->codem;
                $new->birth_date = $bahre->bdate;
                $new->shsh = $bahre->shsh;
                $new->father_name = $bahre->father;
                $new->tel = $bahre->sh_sabt;
                $new->mobile = $bahre->mobile;
                $new->uname = $bahre->codem;
                $new->password = Hash::make($bahre->mobile);
                $new->status = 0;
                $new->save();
            }
            else
            {
                $new = User::where('codemelli',$bahre->codem)->first();
                $new->name = $bahre->name." ".$bahre->family;
                $new->num_pahne = $bahre->no_pahne;
                $new->sex = $bahre->sex;
                $new->codemelli = $bahre->codem;
                $new->birth_date = $bahre->bdate;
                $new->shsh = $bahre->shsh;
                $new->father_name = $bahre->father;
                $new->tel = $bahre->sh_sabt;
                $new->mobile = $bahre->mobile;
                $new->uname = $bahre->codem;
                $new->password = Hash::make($bahre->mobile);
                $new->status = 0;
                $new->save();
            }
            
            $newInfo = new UserInfo;
            $newInfo->user_id = $new->id;
            $newInfo->city_name = $bahre->city;
            $newInfo->mantaghe = $bahre->mantaghe;
            $newInfo->type = $bahre->type;
            $newInfo->sokoonat = $bahre->sokoonat;
            $newInfo->shenasemelli = $bahre->shenasemelli;
            $newInfo->company = $bahre->company;
            $newInfo->sodoor = $bahre->sodoor;
            $newInfo->tahsil_text = $bahre->tahsil;
            $newInfo->mortabet_text = $bahre->mortabet;
            $newInfo->save();
            
            ListBahre::find($bahre->id)->delete();
            
        }
    }
	
	public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
	
	public function checkCodemelli(Request $request)
    {       
     //   return Redirect::to('lock.html');
        $request->user()->authorizeRoles(['admin','manager','programmer','checkPahne']);
		$cmelli = Input::get('codemelli');
		$response = null;
		
		if($cmelli != null)
		{
        $client = new nusoap_client('http://10.7.234.33/bahrebardaran/PahneServices.asmx?wsdl',true);
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;

        $params = array(
            "username" => "fars",
            "password" => "mmGH6734in",
            "type" => "1",
            "PersonNationalCode" => $cmelli
        );
        $response = $client->call("GetPahneFarmInfo", $params);
		}
		
	//	print_r($response);
		
        if($response != null)
            return view('check_codemelli')->with(['model' => $response]);
        else
            return view('check_codemelli')->with(['model' => null]);
    }
	
	public function wallet()
	{ 
		$model = BagPay::where('status',1)->whereBetween('id', [0, 100000])->get();
		
		$i = 0;
		foreach($model as $bagP)
		{
			$check = BagPay::where('bag_id',$bagP->bag_id)
				->where('payment_id',$bagP->payment_id)
				->where('price',$bagP->price)
				->where('typePay_id',182)
				->first();
			
			if($check == null)
			{
				$new = new BagPay;
				$new->bag_id = $bagP->bag_id;
				$new->payment_id = $bagP->payment_id;
				$new->price = $bagP->price;
				$new->status = -1;
				$new->typePay_id = 182;
				$new->save();
				$i++;
			}
		}
		echo $i;
		
	}
	public function lockBroker()
	{ 
		return view('home.lock_broker');
		
	}
}