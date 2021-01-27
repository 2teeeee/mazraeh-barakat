<?php

namespace App\Http\Controllers\Auth;


use App\Helpers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Rules\CheckCodeMelli;

use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

//    protected function authenticated(Request $request, $user)
//    {
//    
//        Sms::sendSMS('به اپلیکیشن مزرعه خوش آمدید.','+982000079',$user->mobile);
//
//     return redirect('/profile/index.html');
//    }
    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'uname' => ['required',new CheckCodeMelli],
            'password' => ['required'],
        ]);
        
        
    }
    
    public function username()
    {
        return 'uname';
    }
}
