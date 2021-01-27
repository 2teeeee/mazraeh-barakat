<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\BazdidRequest;
use App\Models\SamRequest;
use App\Models\Clinic;
use App\Models\City;
use Rafwell\Simplegrid\Grid;
use Auth;

class BazdidRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.info.user');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
        
        return view("admin.bazdidRequest.index")->with([]);
    }
    
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
    	// get all the bazdidRequest
    	$model = BazdidRequest::all();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\bazdidRequest\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\bazdidRequest\create','class'=>'btn-success','icon'=>'pencil'];
        
        $Grid = new Grid(BazdidRequest::query(), 'bazdidRequests');
    	
        $Grid->fields([
          'ostan_id'=>trans('validation.attributes.ostan'),
          'city_id'=>trans('validation.attributes.city'),
          'mobile'=>trans('validation.attributes.mobile'),
          'price'=>trans('validation.attributes.price'),
          'status'=>trans('validation.attributes.status'),
          
        ])->processLine(function($row){
            $a = [0=>'ثبت اولیه',
                1=>'پرداخت شده',
                2=>'انجام شده'];
            
            $row['status'] = $a[$row['status']];
            
            $city = City::find($row['city_id']);
            $row['city_id'] = $city->title;
            $row['ostan_id'] = $city->ostan?$city->ostan->title:""; 

            return $row; 
        })->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.edit'), '{id}/edit')
            ->action(trans('validation.attributes.delete'), '{id}', [
                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
                'method'=>'DELETE',
            ]);
        
        // load the view and pass the bazdidRequest
    	return view("admin.bazdidRequest.all")->with([
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

    public function create($req = 0,$clinic = 0,Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\bazdidRequest\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\bazdidRequest\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/bazdidRequest/all','class'=>'btn-info','icon'=>'book'];

        $request = SamRequest::find($req);
        $clin = Clinic::find($clinic);
        // load the create form (app/views/bazdidRequest/create.blade.php)
        return view("admin.bazdidRequest.create")->with([
            "crumb"=>$crumb,
            "samRequest_id"=>$req,
            "clinic_id"=>$clinic,
            "request"=>$request,
            "clinic"=>$clin,
            "btn"=>$btn,
        ]);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'sam_request_id' => ['nullable'],
            'clinic_id' => ['nullable']
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('bazdidRequest/create')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new BazdidRequest;
            $model->sam_request_id = Input::get('sam_request_id');
            $model->clinic_id = Input::get('clinic_id');
            $model->ostan_id = Input::get('ostan');
            $model->city_id = Input::get('city');
            $model->bakhsh = Input::get('bakhsh');
            $model->roosta = Input::get('roosta');
            $model->address = Input::get('address');
            $model->code = time();
            $model->status = 0;
            $model->user_id = Auth::id();
             $model->price = Input::get('price');
            $model->mobile = Input::get('mobile');
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('bazdidRequest/list');
        }
    }

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id,Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
        
        // get the bazdidRequest
        $model = BazdidRequest::find($id);

        // show the view and pass the bazdidRequest to it
        return View('admin.bazdidRequest.show')->with(
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
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
        
        // get the bazdidRequest
        $model = BazdidRequest::find($id);
        
        $users = User::all();
        
        $btn[0] = ['title'=>'مدیریت','url'=>'/bazdidRequest/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'/bazdidRequest/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the bazdidRequest
        return View('admin.bazdidRequest.edit')->with([
            'model'=>$model,
            'users'=>$users,
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
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'sam_request_id' => ['nullable'],
            'clinic_id' => ['nullable'],
            'price' => ['required', 'numeric'],
            'ostan' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'bakhsh' => ['nullable', 'string'],
            'roosta' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'mobile' => ['required','numeric'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('bazdidRequest/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = BazdidRequest::find($id);
            
            $model->sam_request_id = Input::get('sam_request_id');
            $model->clinic_id = Input::get('clinic_id');
            $model->ostan_id = Input::get('ostan');
            $model->city_id = Input::get('city');
            $model->bakhsh = Input::get('bakhsh');
            $model->roosta = Input::get('roosta');
            $model->address = Input::get('address');
            $model->code = time();
            $model->status = 0;
            $model->price = Input::get('price');
            $model->mobile = Input::get('mobile');
            
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('bazdidRequest/all');
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
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork']);
        
        // delete
        $model = BazdidRequest::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('bazdidRequest/all');
    }
    
    public function listReq(Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer','clinic']);
        
    	// get all the clinic
    	$model = BazdidRequest::where('user_id',Auth::id())->get();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\clinic\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\clinic\create','class'=>'btn-success','icon'=>'pencil'];

        $gridQuery = BazdidRequest::where('user_id',Auth::id());
        
        $Grid = new Grid($gridQuery, 'bazdidRequests');
    	
        $Grid->fields([
          'code'=>trans('validation.attributes.code'),
          'ostan_id'=>trans('validation.attributes.ostan'),
          'city_id'=>trans('validation.attributes.city'),
          'mobile'=>trans('validation.attributes.mobile'),
          'price'=>trans('validation.attributes.price'),
          'status'=>trans('validation.attributes.status'),
          
        ])->processLine(function($row){
            $a = [0=>'ثبت اولیه',
                1=>'پرداخت شده',
                2=>'انجام شده'];
            
            $row['status'] = $a[$row['status']];
            
            $city = City::find($row['city_id']);
            $row['city_id'] = $city->title;
            $row['ostan_id'] = $city->ostan?$city->ostan->title:""; 

            return $row; 
        })->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
     //   $Grid->action(trans('validation.attributes.edit'), '{id}/edit');
        
        // load the view and pass the clinic
    	return view("admin.clinic.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid,
            'tab'=>100
        ]);
    }
}
