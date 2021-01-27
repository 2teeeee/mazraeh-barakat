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
        // $this->middleware('check.info.user');
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
		
		$payments = Payment::whereIn('orderCode',[
			1610533227587840144,
			1610533195676340000,
			1610533269380540145,
			1610533290135540147,
			1610533362132740150,
			1610533405480740153,
			1610533390989340152,
			1610533461420940158,
			1610533479873040160,
			1610533532279940162,
			1610533568452640166,
			1610533992677440178,
			1610534145128940181,
			1610534234182440186,
			1610534177550640183,
			1610534280965240187,
			1610534407932940194,
			1610534598298440201,
			1610534683770940207,
			1610534719775440211,
			1610534710536240210,
			1610534809339540216,
			1610534827767040218,
			1610534885957140220,
			1610535009460140223,
			1610535123144340229,
			1610535220723640234,
			1610535145388340230,
			1610535305698840239,
			1610535351397240241,
			1610535383676940242,
			1610535944456440263,
			1610535576915340250,
			1610536229449140274,
			1610536275537540277,
			1610536205891840273,
			1610536338119940281,
			1610536439280140288,
			1610536476563140295,
			1610536475624440294,
			1610536440550540289,
			1610536435118240287,
			1610536604917440303,
			1610536754433740320,
			1610536707925240314,
			1610536853286940330,
			1610536836834740328,
			1610536894224740331,
			1610537052955540340,
			1610537051716840339,
			1610536929695340333,
			1610537177504840345,
			1610537150874540344,
			1610537349656340354,
			1610537365211840355,
			1610537378173540356,
			1610537415130740358,
			1610537657922440368,
			1610537705200940371,
			1610537847305340374,
			1610537947729440377,
			1610538109607840386,
			1610538411756240394,
			1610538479444040397,
			1610538563165740402,
			1610538636661740406,
			1610538492979540398,
			1610538738867640409,
			1610538625405040405,
			1610538920266440416,
			1610538988690740419,
			1610538833524240413,
			1610539210361140429,
			1610539338912540434,
			1610539344802440435,
			1610539127902240425,
			1610539560388940445,
			1610539682693040456,
			1610539649393440454,
			1610539649112840455,
			1610539483226340439,
			1610539784677140462,
			1610539922435840470,
			1610540053253640477,
			1610539964195340473,
			1610540189504540483,
			1610540164291940480,
			1610540260820640488,
			1610540378827040494,
			1610540257593740487,
			1610540496574640498,
			1610540561480040503,
			1610540584634440504,
			1610540525526540501
		])->get();
		$i = 0;
		foreach($payments as $payment)
		{
			$koodReqs = KoodReq::where('payment_id',$payment->id)->get();
			foreach($koodReqs as $req)
			{
				if($req->status > 0)
				{
					/*
					$model = KoodReq::find($req->id);
					$model->status = -1;
					$model->back_date = now();
					$model->save();

					$new = new BrokerKood;
					$new->broker_id = $model->broker_id;
					$new->kood_id = $model->kood_id;
					$new->value = $model->value;
					$new->tonne = round((($model->value * 50) / 1000),2);
					$new->type = 1;
					$new->user_id = Auth::id();
					$new->comment = 'مرجوع کردن درخواست کود '.$model->kood->title.' برای بهره بردار '.$model->user->name.'بدلیل پرداخت اشتباه ';
					$new->save();
					*/
					$i++;

				}
			}
		}
		echo $i;
		
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
// 6839933751
// 2293002993
// 6839792196
        $response = $client->call("GetPahneFarmInfo", $params);
		}
		
	//	print_r($response);
		
        if($response != null)
            return view('check_codemelli')->with(['model' => $response]);
        else
            return view('check_codemelli')->with(['model' => null]);
    }
}