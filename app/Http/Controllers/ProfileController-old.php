<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ServiceRequest;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Clinic;
use App\Models\Store;
use App\Models\Bahrebardar;
use App\Models\Location;
use App\Models\City;
use App\Models\ProductKoodValue;

use App\User;
use App\Helpers\Sms;
use App\Helpers\Jahad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use nusoap_client;

use App\Rules\CheckMobile;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        
        if(Auth::user()->checkRole(10))
        {
            $check = Location::where('type_id',152)->where('user_id',Auth::id())->count();
            if($check == 0)
                Session::flash('clinic', 'اطلاعات کلینیک شما ثبت نشده است.');
        }
        if(Auth::user()->checkRole(13))
        {
            $check = Location::where('type_id',153)->where('user_id',Auth::id())->count();
            if($check == 0)
                Session::flash('store', 'اطلاعات فروشگاه شما ثبت نشده است.');
        }
        if(Auth::user()->checkRole(6) || Auth::user()->checkRole(7) || Auth::user()->checkRole(8) || Auth::user()->checkRole(9))
        {
            $check = Location::where('type_id',151)->where('user_id',Auth::id())->count();
            if($check == 0)
                Session::flash('bahrebardar', 'اطلاعات مزرعه ی شما ثبت نشده است.');
        }
        $tab = 0;
		
		$userReqs = ProductKoodValue::where('ct_id',Auth::user()->city->ct_id)
			->where('userKeshtReqStatus',1)
			->whereDate('startDate', '<=', date('Y-m-d'))
			->whereDate('endDate', '>=', date('Y-m-d'))
			->get();
		
        return view('profile.index')->with([
            'tab' => $tab,
			'userReqs' => $userReqs
        ]);
    }
    public function copon()
    {
        $tab = 1;
        
        $model = [];
        
        return view('profile.copon')->with([
            'model' => $model,
            'tab' => $tab
        ]);
    }
    public function changeInfo()
    {
        $tab = 2;
        
        $model = $model = User::find(Auth::id());
        
        return view('profile.profile')->with([
            'model' => $model,
            'tab' => $tab
        ]);
    }
    
    public function update()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => ['required', 'string', 'max:255'],
         //   'mobile' => ['required', 'string', 'max:11', 'min:11', new CheckMobile],
            'mobile' => ['required', 'string', 'max:11', 'min:11'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'codemelli' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'string', 'max:255'],
            'level_tahsil' => ['nullable', 'string', 'max:255'],
            'reshte_tahsil' => ['nullable', 'string', 'max:255'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('profile/changeInfo.html')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = User::find(Auth::id());
            $model->name = Input::get('name');
            $model->mobile = Input::get('mobile');
            $model->email = Input::get('email');
            $model->address = Input::get('address');
            $model->father_name = Input::get('father_name');
            $model->birth_date = Input::get('birth_date');
            $model->level_tahsil = Input::get('level_tahsil');
            $model->reshte_tahsil = Input::get('reshte_tahsil');
            $model->save();

//            $frole = RoleUser::where('user_id','=',$model->id)->delete();
//            if(Input::get('role') != null)
//            {
//                $model->roles()->attach(Role::find(1));
//                foreach (Input::get('role') as $key => $value) {
//                    $model->roles()->attach(Role::find($value));
//                }
//            }
                
            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('profile/changeInfo.html');
        }
    }
    
    public function validationInfo()
    {
        $model = $model = User::find(Auth::id());
        
        return view('profile.validation')->with([
            'model' => $model
        ]);
    }
    
    public function updateValidationInfo()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:11', 'min:11', new CheckMobile],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'codemelli' => ['required', 'string', 'max:10', 'min:10'],
            'address' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'string', 'max:255'],
            'level_tahsil' => ['nullable', 'string', 'max:255'],
            'reshte_tahsil' => ['nullable', 'string', 'max:255'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('profile/validationInfo.html')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = User::find(Auth::id());
            $model->name = Input::get('name');
            $model->mobile = Input::get('mobile');
            $model->email = Input::get('email');
            $model->codemelli = Input::get('codemelli');
            $model->status = 1;
            $model->address = Input::get('address');
            $model->check_email = 0;
            $model->check_mobile = 0;
            $model->father_name = Input::get('father_name');
            $model->birth_date = Input::get('birth_date');
            $model->level_tahsil_id = Input::get('level_tahsil');
            $model->reshte_tahsil = Input::get('reshte_tahsil');
            $model->save();
            
//            if(Input::get('role') != null)
//                foreach (Input::get('role') as $key => $value) {
//                    $model->roles()->attach(Role::find($value));
//                }
            

            // redirect
            Session::flash('message', trans('validation.success_update'));
            return Redirect::to('profile/index.html');
        }
    }
    
    public function changePassword()
    {
        $tab = 5;
        
        return view('profile.change_password')->with([
            'tab' => $tab
        ]);
    }
    
    public function updatePassword()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'password'       => 'required',
            'newPassword'       => 'required|confirmed|min:6',
            
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('profile/changePassword.html')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = User::find(Auth::id());

            if (Hash::check(Input::get('password'), $model->password)) { 
                $model->fill([
                    'password' => Hash::make(Input::get('newPassword'))
                ])->save();
               
                // redirect
                Session::flash('message', 'کلمه عبور با موفقیت ویرایش شد..');
                Auth::logout();
                return Redirect::to('login');
            } else {
                Session::flash('error', 'کلمه عبور اشتباه می باشد.');
                return redirect()->to('profile/changePassword.html');
            }
            
            
        }
    }
    
    public function checkInfo()
    {
        $model = User::find(Auth::id());
        $citys = City::all();
        
        return view('profile.check_info')->with([
            'model' => $model,
            'citys' => $citys
        ]);
    }
    
    public function validCheckInfo()
    {
        $rules = array(
            'city_id'       => 'required',
            'address'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('profile/checkInfo.html')
                ->withErrors($validator)->withInput();
        } else {
            
            $model = User::find(Auth::id());
            $model->status = 1;
            $model->zamin_size = 5;
            $model->city_id = Input::get('city_id');
            $model->ostan_id = 17;
            $model->address = Input::get('address');
            $model->save();
            $model->roles()->attach(Role::find(7));
            // redirect
            return Redirect::to('profile/index.html');
        }
    }
    
    public function unValidCheckInfo()
    {
        $model = $model = User::find(Auth::id());
        $model->status = 0;
        $model->save();
        
        Auth::logout();
        // redirect
      
        return view('profile.unvalid_info')->with([
            'message' => 'با توجه به اعلام جناب عالی مبنی بر عدم صحت اطلاعات لطفا به جهاد کشاورزی منطقه خود مراجعه کرده و نسبت به بررسی, تکمیل و اصلاح اطلاعات اقدام نمایید و مجددا وارد سامانه شوید.'
        ]);
    }
    
}