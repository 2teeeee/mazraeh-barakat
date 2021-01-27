<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function __construct()
    {
		$this->middleware('auth');
        $this->middleware('check.info.user');
    }
    
    public function index(Request $request)
    {
        
       $request->user()->authorizeRoles(['admin','manager','programmer']);

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'index.html','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\admin','class'=>'active'];


    	return view('admin.index')->with([
    		'crumb'=>$crumb
    	]);
    }
}
