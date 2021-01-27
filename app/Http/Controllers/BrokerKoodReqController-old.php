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
use App\Models\KargozarKoodValue;
use App\Models\BrokerKood;

use App\Helpers\Sms;
use App\Models\Location;
use Rafwell\Simplegrid\Grid;
use App\User;
use Image;
use Auth;

class BrokerKoodReqController extends Controller
{   
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'درخواست ها','url'=>'','class'=>'active'];

    	// get all the samRequest
    	$model = KoodReq::get();
        
    	$gridQuery = KoodReq::join('users','users.id','=','kood_reqs.user_id')
                ->join('products','products.id','=','kood_reqs.kood_id')
                ->join('products as pr','pr.id','=','kood_reqs.product_id')
                ->where('kood_reqs.broker_id',Auth::id())
                ->where('kood_reqs.status', '=', 1)
                ->orderBy('kood_reqs.created_at','desc');
        
        $Grid = new Grid($gridQuery, 'kood_reqs');
        $Grid->fields([
          'tbl_kood_reqs.code'=>trans('validation.attributes.code'),
          'tbl_users.name'=>trans('validation.attributes.name'),
            'date'=>[
                'label'=>trans('validation.attributes.date'),
                'field'=>"tbl_kood_reqs.make_date"
            ],
          'tbl_users.mobile'=>trans('validation.attributes.mobile'),
            'prod'=>[
                'label'=>'محصول کشت شده',
                'field'=>"tbl_pr.title"
            ],
          'tbl_products.title'=>trans('validation.attributes.kood_id'),
          'tbl_kood_reqs.value'=>trans('validation.attributes.value'),
          
        ])->actionFields([
            'tbl_kood_reqs.id' //The fields used for process actions. those not are showed 
        ])->processLine(function($row){
            //This function will be called for each row
            $row['date'] = jdate($row['date'])->format("Y/m/d");
            //Do more you need on this row
            return $row; //Do not forget to return the row
        });
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view');
        
        // load the view and pass the samRequest
    	return view("admin.request.broker.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }
    
    public function allSend(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'درخواست ها','url'=>'','class'=>'active'];

    	// get all the samRequest
    	$model = KoodReq::get();
        
    	$gridQuery = KoodReq::join('users','users.id','=','kood_reqs.user_id')
                ->join('products','products.id','=','kood_reqs.kood_id')
                ->join('products as pr','pr.id','=','kood_reqs.product_id')
                ->where('kood_reqs.broker_id',Auth::id())
                ->where('kood_reqs.status', '=', 2)
                ->orderBy('kood_reqs.created_at','desc');
      
        $Grid = new Grid($gridQuery, 'kood_reqs');
        $Grid->fields([
          'tbl_kood_reqs.code'=>trans('validation.attributes.code'),
          'tbl_users.name'=>trans('validation.attributes.name'),
            'date'=>[
                'label'=>trans('validation.attributes.date'),
                'field'=>"tbl_kood_reqs.make_date"
            ],
          'tbl_users.mobile'=>trans('validation.attributes.mobile'),
            'prod'=>[
                'label'=>'محصول کشت شده',
                'field'=>"tbl_pr.title"
            ],
          'tbl_products.title'=>trans('validation.attributes.kood_id'),
          'tbl_kood_reqs.value'=>trans('validation.attributes.value'),
          
        ])->actionFields([
            'tbl_kood_reqs.id' //The fields used for process actions. those not are showed 
        ])->processLine(function($row){
            //This function will be called for each row
            $row['date'] = jdate($row['date'])->format("Y/m/d");
            //Do more you need on this row
            return $row; //Do not forget to return the row
        });
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view');
        
        // load the view and pass the samRequest
    	return view("admin.request.broker.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }

    public function allBack(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'درخواست ها','url'=>'','class'=>'active'];
        // get all the samRequest
        $model = KoodReq::get();
        
        $gridQuery = KoodReq::join('users','users.id','=','kood_reqs.user_id')
                ->join('products','products.id','=','kood_reqs.kood_id')
                ->join('products as pr','pr.id','=','kood_reqs.product_id')
                ->where('kood_reqs.broker_id',Auth::id())
                ->where('kood_reqs.status', '=', -1)
                ->orderBy('kood_reqs.created_at','desc');
        
        $Grid = new Grid($gridQuery, 'kood_reqs');
        $Grid->fields([
          'tbl_kood_reqs.code'=>trans('validation.attributes.code'),
          'tbl_users.name'=>trans('validation.attributes.name'),
            'date'=>[
                'label'=>trans('validation.attributes.date'),
                'field'=>"tbl_kood_reqs.make_date"
            ],
          'tbl_users.mobile'=>trans('validation.attributes.mobile'),
            'prod'=>[
                'label'=>'محصول کشت شده',
                'field'=>"tbl_pr.title"
            ],
          'tbl_products.title'=>trans('validation.attributes.kood_id'),
          'tbl_kood_reqs.value'=>trans('validation.attributes.value'),
          
        ])->actionFields([
            'tbl_kood_reqs.id' //The fields used for process actions. those not are showed 
        ])->processLine(function($row){
            //This function will be called for each row
            $row['date'] = jdate($row['date'])->format("Y/m/d");
            //Do more you need on this row
            return $row; //Do not forget to return the row
        });
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view');
        
        // load the view and pass the samRequest
        return view("admin.request.broker.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }

    public function allLast(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'درخواست ها','url'=>'','class'=>'active'];
        // get all the samRequest
        $model = KoodReq::get();
        
        $gridQuery = KoodReq::join('users','users.id','=','kood_reqs.user_id')
                ->join('products','products.id','=','kood_reqs.kood_id')
                ->join('products as pr','pr.id','=','kood_reqs.product_id')
                ->where('kood_reqs.broker_id',Auth::id())
                ->where('kood_reqs.make_date','<',date('Y-m-d', strtotime('-5 days')))
                ->where('kood_reqs.status', '=', 1);
        
        $Grid = new Grid($gridQuery, 'kood_reqs');
        $Grid->fields([
          'tbl_kood_reqs.code'=>trans('validation.attributes.code'),
          'tbl_users.name'=>trans('validation.attributes.name'),
            'date'=>[
                'label'=>trans('validation.attributes.date'),
                'field'=>"tbl_kood_reqs.make_date"
            ],
          'tbl_users.mobile'=>trans('validation.attributes.mobile'),
            'prod'=>[
                'label'=>'محصول کشت شده',
                'field'=>"tbl_pr.title"
            ],
          'tbl_products.title'=>trans('validation.attributes.kood_id'),
          'tbl_kood_reqs.value'=>trans('validation.attributes.value'),
          
        ])->actionFields([
            'tbl_kood_reqs.id' //The fields used for process actions. those not are showed 
        ])->processLine(function($row){
            //This function will be called for each row
            //Do more you need on this row
            $row['date'] = jdate($row['date'])->format("Y/m/d");
            return $row; //Do not forget to return the row
        });
        
        $Grid->action(trans('validation.attributes.view'), '{id}/view');
        
        // load the view and pass the samRequest
        return view("admin.request.broker.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
//            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }
    
    
    public function view($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker']);
    
        $model = KoodReq::find($id);

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'درخواست ها','url'=>url()->previous(),'class'=>''];
        $crumb[2] = ['title'=>'درخواست شماره '.$model->code,'url'=>'','class'=>'active'];
        
        
        return view("admin.request.broker.view")->with([
            "crumb"=>$crumb,
            "model"=>$model
        ]);
    } 
    
    public function check($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker']);
    
        $model = KoodReq::find($id);
        if($model->broker_id == Auth::id())
        {
            if($model->status == 1)
            {
                $model->status = 2;
                $model->send_date = now();
                $model->save();
                
                
                Session::flash('success', 'حواله با موفقیت تحویل داده شد.');
            }
            else
            {
                Session::flash('error', 'حواله فوق مرجوع شده و قابلیت باطل شدن ندارد.');
            }            
        }
        else
        {
            Session::flash('error', 'این حواله به شما اختصاص داده نشده و شما نمی توانید آن را باطل کنید.');
        }
        
        return Redirect::to('brokerKoodReq/'.$model->id.'/view');
    }

    public function back($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','broker']);
    
        $model = KoodReq::find($id);
        if($model->broker_id == Auth::id())
        {
            if($model->status == 1 and $model->make_date < date('Y-m-d', strtotime('-5 days')))
            {
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
                $new->comment = 'مرجوع کردن درخواست کود '.$model->kood->title.' برای بهره بردار '.$model->user->name;
                $new->save();
                
                Session::flash('success', 'درخواست با موفقیت مرجوع شد.');
            }
            else
            {
                Session::flash('error', 'این حواله را نمی توانید مرجوع کنید.');
            }            
        }
        else
        {
            Session::flash('error','این حواله به شما اختصاص داده نشده و شما نمی توانید آن را باطل کنید.');
        }
        
        return Redirect::to('brokerKoodReq/'.$model->id.'/view');
    }

    
    
}
