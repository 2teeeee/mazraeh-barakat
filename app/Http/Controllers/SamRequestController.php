<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\SamRequest;
use App\Models\SamRequestFile;
use App\Models\SamRequestClinic;
use App\Models\SamRequestClinicNoskhe;
use App\Models\SamRequestClinicStore;
use App\Models\Store;
use App\Models\Clinic;
use App\Models\HandyValue;
use App\Models\Bahrebardar;
use App\Models\SamRequestAlaf;
use App\Models\SamRequestAlafkosh;
use App\Models\SamRequestKood;
use Rafwell\Simplegrid\Grid;
use App\User;
use Image;
use Auth;

class SamRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.info.user');
    }
    
    
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
    	// get all the samRequest
    	$model = SamRequest::all();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\samRequest\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\samRequest\create','class'=>'btn-success','icon'=>'pencil'];

        
        $Grid = new Grid(SamRequest::query(), 'samRequests');
    	
        $Grid->fields([
          'bahrebardar_id'=>trans('validation.attributes.bahrebardar'),
          'mahsool_name'=>trans('validation.attributes.mahsool_name'),
          'kesht_date'=>trans('validation.attributes.kesht_date'),
          'status'=>trans('validation.attributes.status'),
          
        ])->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
//        $Grid->action(trans('validation.attributes.edit'), '{id}/edit')
//            ->action(trans('validation.attributes.delete'), '{id}', [
//                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
//                'method'=>'DELETE',
//            ]);
        
        // load the view and pass the samRequest
    	return view("admin.samRequest.all")->with([
            "model"=>$model,
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
 
        // get the samRequest
        $model = SamRequest::find($id);

        // show the view and pass the samRequest to it
        return View('admin.samRequest.show')->with(
            'model', $model
        );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
 
        // get the samRequest
        $model = SamRequest::find($id);
        
        $users = User::all();
        $bahrebardars = Bahrebardar::where('user_id',Auth::id())->get();
        $keshts = HandyValue::where('handy_id',2)->get();
        $bazrs = HandyValue::where('handy_id',3)->get();
        $abs = HandyValue::where('handy_id',4)->get();
        
        $btn[0] = ['title'=>'مدیریت','url'=>'/samRequest/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'/samRequest/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the samRequest
        return View('admin.samRequest.edit')->with([
            'model'=>$model,
            'users'=>$users,
            'keshts'=>$keshts,
            'bazrs'=>$bazrs,
            'abs'=>$abs,
            'bahrebardars'=>$bahrebardars,
            'tab'=>100,
            'btn'=>$btn
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'kesht_type' => ['required'],
            'mahsool_name' => ['required', 'string'],
            'kesht_sath' => ['required', 'string'],
            'bazr_type' => ['required', 'string'],
            'kesht_old' => ['required', 'string'],
            'kesht_date' => ['required', 'string'],
            'ab_start_date' => ['required', 'string'],
            'ab_dore' => ['required', 'string'],
            'kood_type' => ['required', 'string'],
            'ab_ec' => ['required', 'string'],
            'khak_ec' => ['required', 'string'],
            'ab_type' => ['required'],
            'bahrebardar_id' => ['required'],
            'title' => ['required'],
            'small_comment' => ['required'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('samRequest/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = SamRequest::find($id);
            $model->bahrebardar_id = Input::get('bahrebardar_id');
            $model->kesht_type = Input::get('kesht_type');
            $model->mahsool_name = Input::get('mahsool_name');
            $model->kesht_sath = Input::get('kesht_sath');
            $model->bazr_type = Input::get('bazr_type');
            $model->kesht_old = Input::get('kesht_old');
            $model->kesht_date = Input::get('kesht_date');
            $model->ab_start_date = Input::get('ab_start_date');
            $model->ab_dore = Input::get('ab_dore');
            $model->kood_type = Input::get('kood_type');
            $model->ab_ec = Input::get('ab_ec');
            $model->khak_ec = Input::get('khak_ec');
            $model->ab_type = Input::get('ab_type');
            $model->status = Input::get('status');
            $model->title = Input::get('title');
            $model->small_comment = Input::get('small_comment');
            
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('samRequest/all');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
 
        // delete
        $model = SamRequest::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('samRequest/all');
    }
    
    public function newRequest(Request $request)
    {

        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\samRequest\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\samRequest\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/samRequest/all','class'=>'btn-info','icon'=>'book'];

        $types = HandyValue::where('handy_id',1)->get();

        // load the create form (app/views/samRequest/create.blade.php)
        return view("admin.samRequest.new_request")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
            'types'=>$types,
            'tab' => 0
        ]);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function saveRequest(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'num_pahne' => ['required', 'numeric'],
            'ostan' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'bakhsh' => ['nullable', 'string'],
            'mantaghe' => ['nullable', 'string'],
            'roosta' => ['nullable', 'string'],
            'utm' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'type' => ['required'],
            'madarek_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('samRequest/new')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new SamRequest;
            $model->user_id = Auth::id();
            $model->num_pahne = Input::get('num_pahne');
            $model->ostan = Input::get('ostan');
            $model->city = Input::get('city');
            $model->bakhsh = Input::get('bakhsh');
            $model->mantaghe = Input::get('mantaghe');
            $model->roosta = Input::get('roosta');
            $model->utm = Input::get('utm');
            $model->address = Input::get('address');
            $model->type = Input::get('type');
            $model->status = 0;
            
            $image = $request->file('madarek_image');
            if($image != null)
            {
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                Image::make($image)->save($location);
                $model->madarek_image = $filename;
            }
        
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('samRequest/list');
        }
    }
    
    
    
    
    
    
    
    
    
    
    public function okNoskhe($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        $model = SamRequestClinic::find($id);
        $model->status = 5;
        $model->save();
        
        $req = SamRequest::find($model->sam_request_id);
        $req->status = 5;
        $req->save();
        
        Session::flash('message', trans('validation.attributes.success_update'));
        return Redirect::to('samRequest/clinicView/'.$model->id.'/noskhe');
    }
    
    
    public function storeRequest($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
 
        Session::flash('message', 'درخواست شما با موفقیت ثبت شد. پس از تایید فروشگاه اطلاعات آن را مشاهده خواهید کرد.');
        return Redirect::to('samRequest/list');
    }
    
    
    
    
    
    
    
    
    
}
