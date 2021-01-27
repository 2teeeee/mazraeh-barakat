<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Role;
use App\Models\Bag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

use App\Helpers\Sms;
use App\Rules\CodeMelli;
use App\Rules\CheckMobile;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile/index.html';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'terms' => ['required'],
            'mobile' => ['required', 'string','min:11', 'unique:users',new CheckMobile],
//            'mobile' => ['required', 'string','min:11', 'unique:users'],
            'codemelli' => ['required','numeric', 'unique:users',new CodeMelli],
          //  'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $us = User::where('codemelli',$data['codemelli'])->first();
        if($us == null)
        {
            
            $user = User::create([
                'name' => $data['name'],
                'uname' => $data['codemelli'],
                'codemelli' => $data['codemelli'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password']),
                'address' => $data['address'],
                'check_email' => 0,
                'check_mobile' => 0,
                'father_name' => $data['father_name'],
                'birth_date' => $data['birth_date'],
                'level_tahsil_id' => $data['level_tahsil'],
                'reshte_tahsil' => $data['reshte_tahsil'],
                'status' => 1,
                'code' => time(),
            ]);
            $user
                ->roles()
                ->attach(Role::where('name', 'employee')->first());
            
            if(Input::get('role') != null)
                foreach (Input::get('role') as $key => $value) {
                    $user->roles()->attach(Role::find($value));
                }
            
            $bag = new Bag;
            $bag->user_id = $user->id;
            $bag->status = 1;
            $bag->isMain = 1;
            $bag->title = 'کیف اصلی '.$user->code;
            $bag->save();
            
            $mob = $user->mobile;
            Sms::sendSMS('از ثبت نام شما در اپلیکیشن مزرعه سپاسگذاریم.','+9810000002020',"$mob");

        }
        else
        {
                $user = $us;
        }
        Session::flash('message', trans('validation.attributes.success_register'));
        return $user;
    }
}
