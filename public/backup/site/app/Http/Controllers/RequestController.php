<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


use App\Models\Req;
use App\Models\RequestZamin;
use App\Models\RequestBagh;
use App\Models\RequestGolkhaneh;
use App\Models\RequestInfo;
use App\Models\RequestKood;
use App\Models\RequestAlaf;
use App\Models\RequestAlafkosh;
use App\Models\RequestFile;
use App\Models\RequestClinic;
use App\Models\RequestClinicItem;
use App\Models\RequestOrder;
use App\Models\RequestOrderProduct;
use App\Models\RequestOrderOffer;
use App\Models\RequestOrderOfferPrice;
use App\Models\RequestOther;
use App\Models\RequestOtherOffer;
use App\Models\RequestGetKood;
use App\Models\Product;

use App\Helpers\Sms;
use App\Models\Location;
use Rafwell\Simplegrid\Grid;
use App\User;
use Image;
use Auth;

class RequestController extends Controller
{
    public function createSam(Request $request)
    {

        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
     
        $check = Location::where('type_id',151)->where('user_id',Auth::id())->count();
        
        if($check == 0)
        {
            Session::flash('bahrebardar', 'اطلاعات مزرعه ی شما ثبت نشده است. ابتدا مزرعه ی خود را ثبت و پس از تایید مدیریت می توانید از امکانات مزرعه ها استفاده کنید.');
            return Redirect::to('bahrebardar/new');
        }
        else
        {
            $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
            $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\samRequest\all','class'=>''];
            $crumb[2] = ['title'=>'کاربر جدید','url'=>'\samRequest\create','class'=>'active'];

            $btn[0] = ['title'=>'مدیریت','url'=>'/samRequest/all','class'=>'btn-info','icon'=>'book'];


            $users = User::all();

            $bahrebardars = Location::where('type_id',151)->where('user_id',Auth::id())->get();
            // load the create form (app/views/samRequest/create.blade.php)
            return view("admin.request.create")->with([
                "crumb"=>$crumb,
                "btn"=>$btn,
                'users'=>$users,
                'bahrebardars'=>$bahrebardars,
                'tab'=>100,
                'type'=>157
            ]);
        }
    }
    
    public function createSamManager(Request $request)
    {

//        $request->user()->authorizeRoles(['admin','manager','programmer',]);
     
        $check = Location::where('type_id',151)->count();
        
        if($check == 0)
        {
            Session::flash('bahrebardar', 'اطلاعات مزرعه ی شما ثبت نشده است. ابتدا مزرعه ی خود را ثبت و پس از تایید مدیریت می توانید از امکانات مزرعه ها استفاده کنید.');
            return Redirect::to('bahrebardar/new');
        }
        else
        {
            $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
            $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\samRequest\all','class'=>''];
            $crumb[2] = ['title'=>'کاربر جدید','url'=>'\samRequest\create','class'=>'active'];

            $btn[0] = ['title'=>'مدیریت','url'=>'/samRequest/all','class'=>'btn-info','icon'=>'book'];


            $users = User::all();

            $bahrebardars = Location::where('type_id',151)->where('user_id',Auth::id())->get();
            // load the create form (app/views/samRequest/create.blade.php)
            return view("admin.request.create_manager")->with([
                "crumb"=>$crumb,
                "btn"=>$btn,
                'users'=>$users,
                'bahrebardars'=>$bahrebardars,
                'tab'=>100,
                'type'=>157
            ]);
        }
    }
    
    public function storeSam(Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'kesht_type' => ['required'],
            'mahsool_id' => ['required'],
            'kesht_sath' => ['required', 'string', 'min:1'],
            'bazr_type' => ['required', 'string'],
            'kesht_old' => ['required', 'string'],
            // 'kesht_date' => ['required', 'string'],
            'ab_start_date' => ['required', 'string'],
            'ab_dore' => ['required', 'string', 'min:1','max:90'],
            'kood_type' => ['required'],
            'ab_ec' => ['required', 'string'],
            'khak_ec' => ['required'],
            'ab_type' => ['required'],
            'khak_id' => ['nullable'],
            'location' => ['required'],
            // 'title' => ['required'],
            'small_comment' => ['nullable'],
            'abEc_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'khakEc_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/sam/create')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new Req;
            $model->user_id = Auth::id();
            $model->location_id = Input::get('location');
            $model->status = 0;
            $model->requestType_id = Input::get('requestType_id');
            $model->small_comment = Input::get('small_comment');
            if(Input::get('bazdid') == 1) $model->statusBazdid = 1;
            $model->save();
            
            $loc = Location::find($model->location_id);
            
            if($loc->bahrebardar->type_id == 2)
            {
                $zamin = new RequestZamin;
                $zamin->request_id = $model->id;
                $zamin->keshtDate = Input::get('kesht_date');
                $zamin->keshtType_id = Input::get('kesht_type');
                $zamin->bazrType_id = Input::get('bazr_type');
                $zamin->keshtOld_id = Input::get('kesht_old');
                $zamin->abyariFirstDate = Input::get('ab_start_date');
                $zamin->save();
            }
            elseif($loc->bahrebardar->type_id == 3)
            {
                $zamin = new RequestBagh;
                $zamin->request_id = $model->id;
                $zamin->keshtYear = Input::get('keshtYear');
                $zamin->save();
            }
            elseif($loc->bahrebardar->type_id == 4)
            {
                $zamin = new RequestGolkhaneh;
                $zamin->request_id = $model->id;
                $zamin->hasZehkeshi = Input::get('hasZehkeshi');
                $zamin->save();
            }
            
            
            $info = new RequestInfo;
            $info->request_id = $model->id;
            $info->product_id = Input::get('mahsool_id');
            $info->bazr_id = Input::get('bazr_type');
            $info->sath_value = Input::get('kesht_sath');
            $info->sath_type = Input::get('type_sath');
            $info->abType_id = Input::get('ab_ec');
            $info->abyariType_id = Input::get('ab_type');
            $info->abDore_id = Input::get('ab_dore');
            $info->khakColor_id = Input::get('khak_ec');
            $info->khakType_id = Input::get('khak_type');
            $info->hasShoore = Input::get('status_shoore');
            $info->khakBaft_id = Input::get('khak_id');
            
            $image = $request->file('abEc_file');
            if($image != null)
            {
                $filename = time(). '-abEc.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                // Image::make($image)->resize(300, 230)->save($location);
                Image::make($image)->save($location);
                $info->abType_file = $filename;
            }
            
            $image = $request->file('khakEc_file');
            if($image != null)
            {
                $filename = time(). '-khakEc.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                Image::make($image)->save($location);
                $info->khakType_file = $filename;
            }
            $info->save();

            
            if(Input::get('kood_type') != null)
                foreach (Input::get('kood_type') as $key => $value) {
                    $new = new RequestKood;
                    $new->request_id = $model->id;
                    $new->kood_id = $value;
                    $new->save();
                }

            if(Input::get('alaf_id') != null)
                foreach (Input::get('alaf_id') as $key => $value) {
                    $new = new RequestAlaf;
                    $new->request_id = $model->id;
                    $new->alaf_id = $value;
                    $new->save();
                }

            if(Input::get('alafkosh_id') != null)
                foreach (Input::get('alafkosh_id') as $key => $value) {
                    $new = new RequestAlafkosh;
                    $new->request_id = $model->id;
                    $new->alafkosh_id = $value;
                    $new->save();
                }

            
            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('request/getFile/'.$model->id);
        }
    }
    public function storeSamManager(Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'kesht_type' => ['required'],
            'mahsool_id' => ['required'],
            'kesht_sath' => ['required', 'string', 'min:1'],
            'bazr_type' => ['required', 'string'],
            'kesht_old' => ['required', 'string'],
            // 'kesht_date' => ['required', 'string'],
            'ab_start_date' => ['required', 'string'],
            'ab_dore' => ['required', 'string', 'min:1','max:90'],
            'kood_type' => ['required'],
            'ab_ec' => ['required', 'string'],
            'khak_ec' => ['required'],
            'ab_type' => ['required'],
            'khak_id' => ['required'],
            'location' => ['required'],
            // 'title' => ['required'],
            'small_comment' => ['nullable'],
            'abEc_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'khakEc_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/sam/createManager')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new Req;
            $model->user_id = Auth::id();
            $model->location_id = Input::get('location');
            $model->status = 0;
            $model->requestType_id = Input::get('requestType_id');
            $model->small_comment = Input::get('small_comment');
            if(Input::get('bazdid') == 1) $model->statusBazdid = 1;
            $model->save();
            
            $loc = Location::find($model->location_id);
            
            if($loc->bahrebardar->type_id == 2)
            {
                $zamin = new RequestZamin;
                $zamin->request_id = $model->id;
                $zamin->keshtDate = Input::get('kesht_date');
                $zamin->keshtType_id = Input::get('kesht_type');
                $zamin->bazrType_id = Input::get('bazr_type');
                $zamin->keshtOld_id = Input::get('kesht_old');
                $zamin->abyariFirstDate = Input::get('ab_start_date');
                $zamin->save();
            }
            elseif($loc->bahrebardar->type_id == 3)
            {
                $zamin = new RequestBagh;
                $zamin->request_id = $model->id;
                $zamin->keshtYear = Input::get('keshtYear');
                $zamin->save();
            }
            elseif($loc->bahrebardar->type_id == 4)
            {
                $zamin = new RequestGolkhaneh;
                $zamin->request_id = $model->id;
                $zamin->hasZehkeshi = Input::get('hasZehkeshi');
                $zamin->save();
            }
            
            
            $info = new RequestInfo;
            $info->request_id = $model->id;
            $info->product_id = Input::get('mahsool_id');
            $info->bazr_id = Input::get('bazr_type');
            $info->sath_value = Input::get('kesht_sath');
            $info->sath_type = Input::get('type_sath');
            $info->abType_id = Input::get('ab_ec');
            $info->abyariType_id = Input::get('ab_type');
            $info->abDore_id = Input::get('ab_dore');
            $info->khakColor_id = Input::get('khak_ec');
            $info->khakType_id = Input::get('khak_type');
            $info->hasShoore = Input::get('status_shoore');
            $info->khakBaft_id = Input::get('khak_id');
            
            $image = $request->file('abEc_file');
            if($image != null)
            {
                $filename = time(). '-abEc.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                // Image::make($image)->resize(300, 230)->save($location);
                Image::make($image)->save($location);
                $info->abType_file = $filename;
            }
            
            $image = $request->file('khakEc_file');
            if($image != null)
            {
                $filename = time(). '-khakEc.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                Image::make($image)->save($location);
                $info->khakType_file = $filename;
            }
            $info->save();

            
            if(Input::get('kood_type') != null)
                foreach (Input::get('kood_type') as $key => $value) {
                    $new = new RequestKood;
                    $new->request_id = $model->id;
                    $new->kood_id = $value;
                    $new->save();
                }

            if(Input::get('alaf_id') != null)
                foreach (Input::get('alaf_id') as $key => $value) {
                    $new = new RequestAlaf;
                    $new->request_id = $model->id;
                    $new->alaf_id = $value;
                    $new->save();
                }

            if(Input::get('alafkosh_id') != null)
                foreach (Input::get('alafkosh_id') as $key => $value) {
                    $new = new RequestAlafkosh;
                    $new->request_id = $model->id;
                    $new->alafkosh_id = $value;
                    $new->save();
                }

            
            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('request/getFile/'.$model->id);
        }
    }
    
    public function getFile($id,Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        // get the samRequest
        $model = Req::find($id);
        $file = new RequestFile;
        
        $gridQuery = RequestFile::where('request_id',$id);
        
        $Grid = new Grid($gridQuery, 'request_files');
        
        $Grid->fields([
          'file'=>trans('validation.attributes.image'),
          'sound'=>trans('validation.attributes.sound'),
          'comment'=>trans('validation.attributes.comment'),
          
        ])->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $btn[0] = ['title'=>'مدیریت','url'=>'/samRequest/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'/samRequest/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the samRequest
        return View('admin.request.get_file')->with([
            'model'=>$model,
            'tab'=>100,
            'grid'=>$Grid,
            'btn'=>$btn
        ]);
    }
    
    public function saveFile($id,Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'comment' => ['nullable','string'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sound' => 'nullable|max:20048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('samRequest/getFile/'.$id)
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new RequestFile;
            $model->request_id = $id;
            $model->comment = Input::get('comment');
            
            $image = $request->file('file');
            if($image != null)
            {
                $filename = time(). '-im.' . $image->getClientOriginalExtension();
                $location = public_path('image/samRequest/' . $filename);
                Image::make($image)->save($location);
                $model->file = $filename;
            }
            
            $sound = $request->file('sound');
            if($sound != null)
            {
                $filename = time(). '-so.' . $sound->getClientOriginalExtension();
                $location = public_path('image/samRequest/' . $filename);
                Image::make($sound)->save($location);
                $model->sound = $filename;
            }
            
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('request/getFile/'.$id);
        }
    }

    public function endSave($id,Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        // get the samRequest
        $model = Req::find($id);
//        if($model->status < 1)
//            $model->status = 1;
        if($model->status < 1)
            $model->status = 2;
        $model->save();
        
        $clinics = Location::where('type_id',152)->get();
        foreach ($clinics as $clinic) {
            $text = 'درخواست جدیدی منتظر بررسی نسخه می باشد.'."\n".'شماره درخواست: '.$model->id."\n".'اپلیکیشن مزرعه';
            $mob = $clinic->user->mobile;
            //return $mob;
            Sms::sendSMS($text,'+9810000002020',"$mob");
        }
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('request/'.$model->id.'/userClinic');
    }
    
    public function userClinic($id,Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        $req = Req::find($id);
        if($req->requestType_id == 157):
            if($req->status < 5):
                $model = RequestClinic::where('request_id',$id)->whereIn('status',[1,2,3,8,9])->get();

                return view("admin.request.user_clinic")->with([
                    'model'=>$model,
                    'req'=>$req,
                    'tab'=>100
                ]);
            else:
                $clinic = RequestClinic::where('request_id',$id)->where('status','>=',4)->first();

                return Redirect::to('request/clinicView/'.$clinic->id.'/noskhe');
            endif;
        elseif($req->requestType_id == 158):
            return Redirect::to('request/kood/view/'.$req->id);
        endif;
        
    }
    
    public function clinicList(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $check = Location::where('type_id',152)->where('user_id',Auth::id())->count();
        
        if($check == 0)
        {
            Session::flash('clinic', 'اطلاعات کلینیک شما ثبت نشده است. ابتدا کلینیک خود را ثبت و پس از تایید مدیریت می توانید از امکانات کلینیک ها استفاده کنید.');
            return Redirect::to('clinic/new');
        }
        else
        {
            $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
        
            $model = Req::whereIn('status',[2,4])->OrWhere('status','>=', 5)->Where('clinic_id', $clinic->id)->
                    orderBy('created_at', 'desc')->orderBy('status','desc')->get();

            return view("admin.request.clinic_list")->with([
                'model'=>$model,
                'tab'=>100
            ]);
        }
    }
    
    public static function searchClinic($id,$clinic)
    {
        if($clinic != null)
            $model = RequestClinic::where('clinic_id',$clinic->id)->where('request_id',$id)->first();
        else
            $model = null;
        return $model;
    }
    
    public function clinicView($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
        $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
 
        // get the samRequest
        $model = Req::find($id);
        
        $clinicSend = $this->searchClinic($id,$clinic);
                
        if($clinicSend != null):
            if($clinicSend->status == 1)
                Session::flash('status', 'درخواست مستندات بیشتری کرده اید. هنوز جوابی دریافت نشده.');
            if($clinicSend->status == 2)
                Session::flash('status', 'بازدید میدانی را تعیین کرده اید. هنوز جوابی دریافت نشده.');
            if($clinicSend->status == 8)
                Session::flash('status', 'ارجاع به آزمایشگاه آب و خاک را تعیین کرده اید. هنوز جوابی دریافت نشده.');
            if($clinicSend->status == 9)
                Session::flash('status', 'ارجاع به اینسکتاریوم را تعیین کرده اید. هنوز جوابی دریافت نشده.');
        endif;

        // show the view and pass the samRequest to it
        return View('admin.request.clinic_view')->with([
            'model'=> $model,
            'clinicSend'=> $clinicSend
        ]);
    }
    
    public function needFile($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
        
        $model = $this->searchClinic($id,$clinic);
        
        if($model != null)
        {
            $model->status = 1;
            $model->save();
        }
        else
        {
            $model = new RequestClinic;
            $model->request_id = $id;
            $model->clinic_id = $clinic->id;
            $model->status = 1;
            $model->save();
        }
        
        $req = Req::find($model->request_id);
        $req->status = 4;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('request/clinicView/'.$id);
    }
    
    
    public function needView($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
        
        $model = $this->searchClinic($id,$clinic);
        
        if($model != null)
        {
            $model->status = 2;
            $model->save();
        }
        else
        {
            $model = new RequestClinic;
            $model->request_id = $id;
            $model->clinic_id = $clinic->id;
            $model->status = 2;
            $model->save();
        }
        
        $req = Req::find($model->request_id);
        $req->status = 4;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('request/clinicView/'.$id);
    }
    
    public function needAzmayesh($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
        
        $model = $this->searchClinic($id,$clinic);
        
        if($model != null)
        {
            $model->status = 8;
            $model->save();
        }
        else
        {
            $model = new RequestClinic;
            $model->request_id = $id;
            $model->clinic_id = $clinic->id;
            $model->status = 8;
            $model->save();
        }
        
        $req = Req::find($model->request_id);
        $req->status = 4;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('request/clinicView/'.$id);
    }
    
    public function needInstkario($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
        
        $model = $this->searchClinic($id,$clinic);
        
        if($model != null)
        {
            $model->status = 9;
            $model->save();
        }
        else
        {
            $model = new RequestClinic;
            $model->request_id = $id;
            $model->clinic_id = $clinic->id;
            $model->status = 9;
            $model->save();
        }
        
        $req = Req::find($model->request_id);
        $req->status = 4;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('request/clinicView/'.$id);
    }
    
    public function alertNoskhe($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
        $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
        
        $model = $this->searchClinic($id,$clinic);
        
        if($model != null)
        {
            $model->status = 3;
            $model->save();
        }
        else
        {
            $model = new RequestClinic;
            $model->request_id = $id;
            $model->clinic_id = $clinic->id;
            $model->status = 3;
            $model->save();
        }
                
        $req = Req::find($id);
        $req->status = 4;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_send_alert'));
        return Redirect::to('request/clinicView/'.$id);
    }
    
    public function listUser(Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
    	// get all the samRequest
    	$model = Req::where('user_id',Auth::id())->get();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\samRequest\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\samRequest\create','class'=>'btn-success','icon'=>'pencil'];
        
        $gridQuery = Req::where('user_id',Auth::id())->orderBy('created_at', 'desc');
        
        $Grid = new Grid($gridQuery, 'samRequests');
    	
        $Grid->fields([
            'title'=>[
                'label'=>trans('validation.attributes.title'),
                'field'=>"id"
            ],
            'date'=>[
                'label'=>trans('validation.attributes.date'),
                'field'=>"created_at"
            ],
          'status'=>[
                'label'=>trans('validation.attributes.status'),
                'field'=>'status'
            ]          
        ])->processLine(function($row){
            $a = [0=>'ثبت اولیه',
                1=>'ثبت نهایی سفارش',
                2=>'تایید شده',
                3=>'مورد تایید نیست',
                4=>'کلینیک اعلام آمادگی کرده',
                5=>'کلینیک انتخاب شده',
                6=>'نسخه ارسال شده',
                7=>'سفارش خرید',
                8=>'قیمت ارائه شده',
                9=>'خرید انجام شده',
                10=>'درخواست خدمات',
                11=>'درسافت پیشنهاد خدمات',
                12=>'پرداخت',
                13=>'اتمام درخواست'];
            
            $row['status'] = $a[$row['status']];
            $req = Req::find($row['id']);
            if($req->requestType_id == 157)
                $row['title'] = 'درخواست سم شماره '.$req->id;
            elseif($req->requestType_id == 158)
                $row['title'] = 'درخواست کود شماره '.$req->id;
            
            $row['date'] = jdate($row['date'])->format('Y/m/d ساعت: H:i:s ');
            return $row; 
        })->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action('مشاهده درخواست', '{id}/userClinic',['icon'=>'fas fa-eye fa-2x','onlyIcon'=>true]);
        
        // load the view and pass the samRequest
    	return view("admin.request.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid,
            'tab'=>100
        ]);
    }
    
    public function clinicSelect($id,Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        $model = RequestClinic::find($id);
        $model->status = 4;
        $model->save();
        
        $req = Req::find($model->request_id);
        $req->status = 5;
        $req->clinic_id = $model->clinic_id;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('request/clinicView/'.$model->id.'/noskhe');
    }
    
    public function noskheView($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        $model = RequestClinic::find($id);
        
        $offerPay = $model->request->order?($model->request->order->offerSelect()?$model->request->order->offerSelect()->sumPrice():0):0;
        $otherPay = 0;
        foreach($model->request->others as $other)
        {
             $otherPay += $other->selectOffer()?$other->selectOffer()->price:0;
        }
        $price = $offerPay + $otherPay;
        
        return view("admin.request.noskhe_view")->with([
            'model'=>$model,
            'totalSum' => $price,
            'tab'=>100
        ]);
        
    }
    
    public function sendNoskhe($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $clinic = Location::where('type_id',152)->where('user_id',Auth::id())->first();
        
        $model = $this->searchClinic($id,$clinic);
        
        $Grid = RequestClinicItem::where('request_clinic_id',$model->id)->get();
        
        
        return View('admin.request.send_noskhe')->with([
            'model'=> $model,
            'grid'=>$Grid
        ]);
    }
    
    public function saveNoskhe(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $id = Input::get('noskhe_id');
        $model = RequestClinic::find($id);

        $rules = array(
            'tashkhis' => ['required','string'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/sendNoskhe/'.$model->request_id)
                ->withErrors($validator)->withInput();
        } else {
            
        
            $model->tashkhis = Input::get('tashkhis');
            $model->status = 5;
            $model->save();

            $req = Req::find($model->request_id);
            $req->status = 6;
            $req->save();

            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('request/clinicView/'.$model->request_id);
        }
    }
    
    public function storeItemNoskhe(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
        
        $rules = array(
            'title'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/sendNoskhe/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
        
            $pNew = new RequestClinicItem;
            $pNew->request_clinic_id = Input::get('id');
            $pNew->product_id = Input::get('title');
            $pNew->disc = Input::get('disc');
            $pNew->formul = Input::get('formul');
            $pNew->food = Input::get('food');
            $pNew->ravesh = Input::get('ravesh');
            $pNew->mizan = Input::get('mizan');
            $pNew->behtarin_zaman = Input::get('behtarin_zaman');
            $pNew->comment = Input::get('comment');
            
            if( $pNew->save())
            {
                echo json_encode(array(
                    'pid'=>$pNew->id,
                    'title'=>$pNew->product?$pNew->product->title:"",
                    'disc'=>$pNew->disc?$pNew->disc:"",
                    'formul'=>$pNew->formul?$pNew->formul:"",
                    'food'=>$pNew->food?$pNew->food:"",
                    'ravesh'=>$pNew->ravesh?$pNew->ravesh:"",
                    'mizan'=>$pNew->mizan?$pNew->mizan:"",
                    'behtarin_zaman' => $pNew->behtarin_zaman?$pNew->behtarin_zaman:"",
                ));
            }
            else
                return 0;
        }
    }
    
    public function deleteItemNoskhe(Request $request)
    {
     
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
 
        $id = Input::get('id');
        $model = RequestClinicItem::find($id);
        $model->delete();
        
        
        return 1;
    }
    
    public function reciptClinic($id,Request $request)
    {
        $model = RequestClinic::where('request_id',$id)->where('status','>=',5)->first();
        
        return View('admin.request.recipt_clinic')->with([
            'model' => $model
        ]);
    }
    
    public function saveRequestStore($id,Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        $rules = array(
            'sel' => 'required',
            'address'       => 'required',
            'mobile'       => 'required',
            'send_date'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/clinicView/'.$id.'/noskhe')
                ->withErrors($validator)->withInput();
        } else {
        
            $pNew = RequestClinic::find($id);
            $pNew->status = 6;
            $pNew->save();
            
            $order = new RequestOrder;
            $order->request_id = $pNew->request_id;
            $order->address = Input::get('address');
            $order->mobile = Input::get('mobile');
            $order->sendDate = Input::get('send_date');
            $order->status = 0;
            
            if($order->save()):
                foreach (Input::get('sel') as $value) {
                    $pr = RequestClinicItem::find($value);
                    
                    $orderProduct = new RequestOrderProduct;
                    $orderProduct->request_order_id = $order->id;
                    $orderProduct->product_id = $pr->product_id;
                    $orderProduct->value = $pr->value;
                    $orderProduct->save();
                }
            endif;
            
            Req::where('id',$pNew->request_id)->update(['status'=>7]);
                
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('request/clinicView/'.$id.'/noskhe');
        }
    }
    
    
    public function storeList(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','pesticideShop']);
 
        $check = Location::where('type_id',153)->where('user_id',Auth::id())->count();
        
        if($check == 0)
        {
            Session::flash('store', 'اطلاعات فروشگاه شما ثبت نشده است. ابتدا فروشگاه خود را ثبت و پس از تایید مدیریت می توانید از امکانات فروشگاه ها استفاده کنید.');
            return Redirect::to('store/new');
        }
        else
        {
            
            $store = Location::where('type_id',153)->where('user_id',Auth::id())->first();
            $kargozar = Location::where('type_id',175)->where('user_id',Auth::id())->first();
            
            if($kargozar == null and $store != null)
                $model = Req::where('status',7)->whereIn('requestType_id',[157,158])->orWhere('store_id',$store->id)->orderBy('created_at', 'desc')->get();
            if($kargozar != null and $store == null)
                $model = Req::where('status',7)->where('requestType_id',158)->orWhere('store_id',$store->id)->orderBy('created_at', 'desc')->get();
            if($kargozar != null and $store != null)
                $model = Req::where('status',7)->whereIn('requestType_id',[157,158])->orWhere('store_id',$store->id)->orderBy('created_at', 'desc')->get();

            return view("admin.request.store_list")->with([
                'model'=>$model,
                'tab'=>100,
                'store'=>$store
            ]);
        }
    }
    
    public function storeView($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','pesticideShop']);
 
        // get the samRequest
        $model = Req::find($id);

        $order = RequestOrder::where('request_id',$id)->where('status',0)->first();
        // show the view and pass the samRequest to it
        if($model->requestType_id == 157):
            return View('admin.request.store_view')->with([
                'model' => $model,
                'order' => $order
            ]);
        elseif($model->requestType_id == 158):
            return View('admin.request.kood.store_view')->with([
                'model' => $model,
                'order' => $order
            ]);
        endif;
    }
    
    public function sendAnswerStore($id,Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer','pesticideShop']);
 
        $store = Location::where('type_id',153)->where('user_id',Auth::id())->first();
        
        $order = RequestOrder::find($id);
        
        $rules = array(
            'price'       => 'required|string',
            'comment'       => 'nullable',
            'work_date'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('Request/storeView/'.$clinic->sam_request_id)
                ->withErrors($validator)->withInput();
        } else {
            $val = Input::get('val');
            
            $new = new RequestOrderOffer;
            $new->request_order_id = $order->id;
            $new->comment = Input::get('comment');
            $new->sendTime = Input::get('work_date');
            $new->status = 0;
            $new->store_id = $store->id;
            $new->save();
            
            foreach($val as $key => $item)
            {
                $prOrder = new RequestOrderOfferPrice;
                $prOrder->request_order_offer_id = $new->id;
                $prOrder->request_order_product_id = $key;
                $prOrder->price = $item['price'];
                $prOrder->brand = $item['mark'];
                $prOrder->country = $item['country'];
                $prOrder->save();
            }
            
            $order->status = 1;
            $order->save();
            
            $req = Req::find($order->request_id);
            $req->status =8;
            $req->save();
            
            if($req->requestType_id == 157):
                $reqClinic = RequestClinic::where('request_id',$req->id)->where('clinic_id',$req->clinic_id)->first();
                $reqClinic->status = 7;
                $reqClinic->save();
            elseif($req->requestType_id == 158):
                $requestGetKood = RequestGetKood::where('request_id',$req->id)->first();
                $requestGetKood->status = 1;
                $requestGetKood->save();
            endif;
            
                
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('request/storeList');
        }
    }
    
   
    public function storeSelect($id,Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        $model = RequestOrderOffer::find($id);
        $model->status =1;
        $model->save();
        
        $req = Req::find($model->order->request_id);
        $req->store_id = $model->store_id;
        $req->status = 9;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_update'));
        if($req->requestType_id == 157):
            
            $reqClinic = RequestClinic::where('request_id',$req->id)->where('clinic_id',$req->clinic_id)->first();
            $reqClinic->status = 8;
            $reqClinic->save();
            
            return Redirect::to('request/clinicView/'.$reqClinic->id.'/noskhe');
        elseif($req->requestType_id == 158):
            return Redirect::to('request/kood/view/'.$req->id);
        endif;
    }
    
    public function otherService($id,Request $request)
    {
    //    $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
    
        // get the samRequest
        $model = Req::find($id);
        
        
        // show the view and pass the samRequest to it
        return View('admin.request.other')->with([
            'model'=> $model
        ]);
    }
    
    public function saveOther($id,Request $request)
    {
        
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        $req = Req::find($id);
        
        $rules = array(
            'address'       => 'required',
            'mobile'       => 'required',
            'send_date'       => 'required',
            'vipType' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/other/'.$id)
                ->withErrors($validator)->withInput();
        } else {
        
            $order = new RequestOther;
            $order->request_id = $id;
            $order->address = Input::get('address');
            $order->mobile = Input::get('mobile');
            $order->sendDate = Input::get('send_date');
            $order->type_id = Input::get('vipType');
            $order->status = 0;
            $order->save();
            
            Session::flash('message', trans('validation.attributes.success_save'));
            if($req->requestType_id == 157):
                $cli = $req->clinicSelect()->id;
                return Redirect::to('request/clinicView/'.$cli.'/noskhe');
            elseif($req->requestType_id == 158):
                return Redirect::to('request/kood/view/'.$id);
            endif;
        }
    }
    
    public function afatkoshShopList(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','pesticideShop']);
 
        $check = Location::where('type_id',156)->where('user_id',Auth::id())->count();
        
        if($check == 0)
        {
            Session::flash('store', 'اطلاعات شرکت دفع آفات شما ثبت نشده است. ابتدا شرکت دفع آفات خود را ثبت و پس از تایید مدیریت می توانید از امکانات آن استفاده کنید.');
            return Redirect::to('dafAfat/new');
        }
        else
        {
            $store = Location::where('type_id',156)->where('user_id',Auth::id())->first();
            $model = RequestOther::where('status',0)->orWhere('store_id',$store->id)->orderBy('created_at', 'desc')->get();

            return view("admin.request.afatkosh_list")->with([
                'model'=>$model,
                'tab'=>100,
                'store'=>$store
            ]);
        }
    }
    
    public function afatkoshView($id,Request $request)
    {
        $model = RequestOther::find($id);
        
        return View('admin.request.recipt_afatkosh')->with([
            'model' => $model
        ]);
    }
    
    public function afatkoshShopView($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','pesticideShop']);
 
        // get the samRequest
        $order = RequestOther::find($id);
        $model = Req::find($order->request_id);

        // show the view and pass the samRequest to it
        return View('admin.request.afatkosh_view')->with([
            'model' => $model,
            'order' => $order
        ]);
    }
    
    public function sendAnswerAfatkoshShop($id,Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer','pesticideShop']);
 
        $store = Location::where('type_id',156)->where('user_id',Auth::id())->first();
        
        $order = RequestOther::find($id);
        
        $rules = array(
            'price'       => 'required|string',
            'comment'       => 'nullable',
            'work_date'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/afatkoshShopView/'.$order->id)
                ->withErrors($validator)->withInput();
        } else {
            $val = Input::get('val');
            
            $new = new RequestOtherOffer;
            $new->request_other_id = $order->id;
            $new->comment = Input::get('comment');
            $new->sendTime = Input::get('work_date');
            $new->price = Input::get('price');
            $new->status = 0;
            $new->store_id = $store->id;
            $new->save();
                
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('request/afatkoshShopList');
        }
    }
    
   
    public function afatkoshShopSelect($id,Request $request)
    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
 
        $model = RequestOtherOffer::find($id);
        $model->status =1;
        $model->save();
        
        $req = RequestOther::find($model->request_other_id);
        $req->status = 1;
        $req->store_id = $model->store_id;
        $req->save();
        
        $requ = Req::find($req->request_id);
        
        Session::flash('message', trans('validation.attributes.success_update'));
        if($requ->requestType_id == 157):
            $reqClinic = $requ->clinicSelect()->id;
            return Redirect::to('request/clinicView/'.$reqClinic.'/noskhe');
        elseif($requ->requestType_id == 158):
            return Redirect::to('request/kood/view/'.$requ->id);
        endif;
    }
    
    
    
    
    
    public function createKood(Request $request)
    {

//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
     
        $check = Location::where('type_id',151)->where('user_id',Auth::id())->count();
        
        if($check == 0)
        {
            Session::flash('bahrebardar', 'اطلاعات مزرعه ی شما ثبت نشده است. ابتدا مزرعه ی خود را ثبت و پس از تایید مدیریت می توانید از امکانات مزرعه ها استفاده کنید.');
            return Redirect::to('bahrebardar/new');
        }
        else
        {
            $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
            $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\samRequest\all','class'=>''];
            $crumb[2] = ['title'=>'کاربر جدید','url'=>'\samRequest\create','class'=>'active'];

            $btn[0] = ['title'=>'مدیریت','url'=>'/samRequest/all','class'=>'btn-info','icon'=>'book'];


            $users = User::all();

            $bahrebardars = Location::where('type_id',151)->where('user_id',Auth::id())->get();
            // load the create form (app/views/samRequest/create.blade.php)
            return view("admin.request.kood.create")->with([
                "crumb"=>$crumb,
                "btn"=>$btn,
                'users'=>$users,
                'bahrebardars'=>$bahrebardars,
                'tab'=>100,
                'type'=>158
            ]);
        }
    }
    
    public function storeKood(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'kesht_type' => ['required'],
            'mahsool_id' => ['required'],
            'kesht_sath' => ['required', 'string', 'min:1'],
            'bazr_type' => ['required', 'string'],
            // 'kesht_date' => ['required', 'string'],
            'location' => ['required'],
            'koodget_type' => ['required'],
            'sendType' => ['required'],
            // 'title' => ['required'],
            'small_comment' => ['nullable'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('request/kood/create')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new Req;
            $model->user_id = Auth::id();
            $model->location_id = Input::get('location');
            $model->status = 1;
            $model->requestType_id = Input::get('requestType_id');
            $model->small_comment = Input::get('small_comment');
            if(Input::get('bazdid') == 1) $model->statusBazdid = 1;
            $model->save();
            
            $loc = Location::find($model->location_id);
            
            if($loc->bahrebardar->type_id == 2)
            {
                $zamin = new RequestZamin;
                $zamin->request_id = $model->id;
                $zamin->keshtDate = Input::get('kesht_date');
                $zamin->keshtType_id = Input::get('kesht_type');
                $zamin->bazrType_id = Input::get('bazr_type');
                $zamin->save();
            }
            elseif($loc->bahrebardar->type_id == 3)
            {
                $zamin = new RequestBagh;
                $zamin->request_id = $model->id;
                $zamin->keshtYear = Input::get('keshtYear');
                $zamin->save();
            }
            elseif($loc->bahrebardar->type_id == 4)
            {
                $zamin = new RequestGolkhaneh;
                $zamin->request_id = $model->id;
                $zamin->hasZehkeshi = Input::get('hasZehkeshi');
                $zamin->save();
            }
            
            $info = new RequestInfo;
            $info->request_id = $model->id;
            $info->product_id = Input::get('mahsool_id');
            $info->bazr_id = Input::get('bazr_type');
            $info->sath_value = Input::get('kesht_sath');
            $info->sath_type = Input::get('type_sath');
            
            $info->save();

            
            $kg = Product::find(Input::get('koodget_type'));
            
            $koodGet = new RequestGetKood;
            $koodGet->request_id = $model->id;
            $koodGet->product_id = Input::get('koodget_type');
            $koodGet->value = Input::get('kesht_sath') * $kg->valueGet;
            $koodGet->sendType_id = Input::get('sendType');
            $koodGet->status = 0;
            $koodGet->save();

            
            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('request/kood/view/'.$model->id);
        }
    }
    
//    public function requestView($id,Request $request)
//    {
//        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
//            'greenhouseOwner','ornamentalWork']);
//        // get the samRequest
//        $model = Req::find($id);
//        
//        
//        // show the view and pass the samRequest to it
//        return View('admin.request.kood.view')->with([
//            'model'=> $model
//        ]);
//    }
    public function listPahne(Request $request)
    {
    	
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
 
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\samRequest\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\samRequest\create','class'=>'btn-success','icon'=>'pencil'];

//        $gridQuery = Req::whereHas('bahrebardar',function($query){
//                $query->where("num_pahne",Auth::user()->num_pahne);
//            })->whereIn('status',[0,1]);
        $gridQuery = Req::whereIn('status',[0,1])->orderBy('created_at', 'desc');
        
        $Grid = new Grid($gridQuery, 'Req');
    	
        $Grid->fields([
            'title'=>[
                'label'=>trans('validation.attributes.title'),
                'field'=>"id"
            ],
            'date'=>[
                'label'=>trans('validation.attributes.date'),
                'field'=>"created_at"
            ],
          'status'=>trans('validation.attributes.status'),
          
        ])->processLine(function($row){
            $a = [0=>'ثبت اولیه',
                1=>'ثبت نهایی سفارش',
                2=>'تایید شده',
                3=>'مورد تایید نیست',
                4=>'کلینیک اعلام آمادگی کرده',
                5=>'کلینیک انتخاب شده',
                6=>'نسخه ارسال شده',
                7=>'سفارش خرید',
                8=>'قیمت ارائه شده',
                9=>'خرید سم انجام شده',
                10=>'درخواست خدمات',
                11=>'درسافت پیشنهاد خدمات',
                12=>'پرداخت',
                13=>'اتمام درخواست'];
            
            $row['status'] = $a[$row['status']];
            
            $req = Req::find($row['id']);
            if($req->requestType_id == 157):
                $row['title'] = 'درخواست سم شماره '.$row['id'];
            elseif($req->requestType_id == 158):
                $row['title'] = 'درخواست کود شماره '.$row['id'];
            endif;
            
            $row['date'] = jdate($row['date'])->format('%Y/%m/%d ساعت: H:i:s ');
            return $row; 
        })->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.check_pahne'), '{id}/checkPahne');
        
        // load the view and pass the samRequest
    	return view("admin.samRequest.list_pahne")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid,
            'tab'=>100
        ]);
    }
    
    
    public function checkPahne($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
 
        // get the samRequest
        $model = Req::find($id);

        // show the view and pass the samRequest to it
        return View('admin.request.check_pahne')->with(
            'model', $model
        );
    }
    
    public function checkOk($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
 
        // get the samRequest
        $model = Req::find($id);
        $model->status = 7;
        $model->save();
        
        if($model->requestType_id == 158):
            
            $order = new RequestOrder;
            $order->request_id = $model->id;
            $order->address = $model->location->address;
            $order->mobile = $model->location->tel;
            $order->status = 0;
            $order->save();
                    
            $orderProduct = new RequestOrderProduct;
            $orderProduct->request_order_id = $order->id;
            $orderProduct->product_id = $model->getKood->product_id;
            $orderProduct->value = $model->getKood->value;
            $orderProduct->save();
            
        endif;
        
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('request/listPahne');
    }
    
    
    public function checkNotOk($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
        
        $rules = array(
            'pahneComment' => ['required','string'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('samRequest/'.$id.'/checkPahne')
                ->withErrors($validator)->withInput();
        } else {
            // get the samRequest
            $model = Req::find($id);
            $model->status = 3;
            $model->pahneComment = Input::get('pahneComment');
            $model->save();

            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('request/listPahne');
        }
    }
    
    public function koodView($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        $model = Req::find($id);
        
        $offerPay = $model->order?($model->order->offerSelect()?$model->order->offerSelect()->sumPrice():0):0;
        $otherPay = 0;
        foreach($model->others as $other)
        {
             $otherPay += $other->selectOffer()?$other->selectOffer()->price:0;
        }
        $price = $offerPay + $otherPay;
        
        return view("admin.request.kood.view")->with([
            'model'=>$model,
            'totalSum'=>$price
        ]);
        
    }
    
    public function reciptStore($id,Request $request)
    {
        $model = Req::find($id);
        
        return View('admin.request.recipt_store')->with([
            'model' => $model
        ]);
    }
    
    
    
    public function checkType()
    {
        $id = Input::get('id');
        $loc = Location::find($id);
        
        return $loc->bahrebardar?$loc->bahrebardar->type_id:0;
    }
    public function rate()
    {
        $id = Input::get('id');
        $rate = Input::get('rate');
        $model = Req::find($id);
        $model->rate = $rate;
        $model->save();
        return 1;
    }
}
