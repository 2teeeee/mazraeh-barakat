<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\Location;
use App\Models\Bahrebardar;
use App\Models\HandyValue;
use App\Models\City;
use Rafwell\Simplegrid\Grid;
use App\User;
use Image;
use Auth;

class BahrebardarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['check.info.user']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork','agency']);
        return view("admin.bahrebardar.index")->with([]);
    }
    
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);

    	$model = Location::where('type_id',151)->get();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\bahrebardar\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\bahrebardar\create','class'=>'btn-success','icon'=>'pencil'];

        
        $query = Location::where('type_id',151);
        $Grid = new Grid($query, 'locations');
    	
        $Grid->fields([
            'title'=>trans('validation.attributes.title'),
            'user_id'=>trans('validation.attributes.user'),
            'type_id'=>trans('validation.attributes.type'),
            'ostan_id'=>trans('validation.attributes.ostan'),
            'city_id'=>trans('validation.attributes.city'),
        ])->processLine(function($row){
            $user = User::find($row['user_id']);
            $row['user_id'] = $user->name;
            
            $bah = Bahrebardar::where('location_id',$row['id'])->first();
            $type = HandyValue::find($bah->type_id);
            $row['type_id'] = $type->title;
            
            $city = City::find($row['city_id']);
            $row['city_id'] = $city->title;
            $row['ostan_id'] = $city->ostan->title;
            
            return $row; 
        })->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.edit'), '{id}/edit',['onlyIcon'=>true,'icon'=>'fas fa-edit'])
            ->action(trans('validation.attributes.delete'), '{id}', [
                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
                'method'=>'DELETE',
                'onlyIcon'=>true,
                'icon'=>'fas fa-trash-alt'
            ]);
        
        // load the view and pass the bahrebardar
    	return view("admin.bahrebardar.all")->with([
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

    public function create(Request $request)
    {

        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\bahrebardar\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\bahrebardar\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/bahrebardar/all','class'=>'btn-info','icon'=>'book'];

        $users = User::all();
        
        // load the create form (app/views/bahrebardar/create.blade.php)
        return view("admin.bahrebardar.create")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
            'users'=>$users,
        ]);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title' => ['required'],
            'user_id' => ['required'],
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
            return Redirect::to('bahrebardar/create')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new Location;
            $model->title = Input::get('title');
            $model->user_id = Input::get('user_id');
            $model->ostan_id = Input::get('ostan_id');
            $model->city_id = Input::get('city_id');
            $model->bakhsh = Input::get('bakhsh');
            $model->mantaghe = Input::get('mantaghe');
            $model->roosta = Input::get('roosta');
            $model->utmLat = Input::get('utmLat');
            $model->utmLang = Input::get('utmLang');
            $model->address = Input::get('address');
            $model->type_id = 151;
            $model->status = 1;
        
            $model->save();
            $model->code = 'b-'.$model->id;
            $model->save();

            
            $bahre = new Bahrebardar;
            $bahre->location_id = $model->id;
            $bahre->num_pahne = Input::get('num_pahne');
            $bahre->type_id = Input::get('type');
            
            $image = $request->file('madarek_image');
            if($image != null)
            {
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                Image::make($image)->resize(300, 230)->save($location);
                $bahre->madarek_image = $filename;
            }
            
            $bahre->save();
            
            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('bahrebardar/all');
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
        // get the bahrebardar
        $model = Bahrebardar::find($id);

        // show the view and pass the bahrebardar to it
        return View('admin.bahrebardar.show')->with(
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
        // get the bahrebardar
        $model = Bahrebardar::find($id);
        
        $users = User::all();
        $types = HandyValue::where('handy_id',1)->get();
        
        $btn[0] = ['title'=>'مدیریت','url'=>'/bahrebardar/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'/bahrebardar/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the bahrebardar
        return View('admin.bahrebardar.edit')->with([
            'model'=>$model,
            'users'=>$users,
            'types'=>$types,
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
            'title' => ['required'],
            'user_id' => ['required'],
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
            return Redirect::to('bahrebardar/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = Bahrebardar::find($id);
            $model->title = Input::get('title');
            $model->user_id = Input::get('user_id');
            $model->num_pahne = Input::get('num_pahne');
            $model->ostan = Input::get('ostan');
            $model->city = Input::get('city');
            $model->bakhsh = Input::get('bakhsh');
            $model->mantaghe = Input::get('mantaghe');
            $model->roosta = Input::get('roosta');
            $model->utm = Input::get('utm');
            $model->address = Input::get('address');
            $model->type = Input::get('type');
            
            $image = $request->file('madarek_image');
            if($image != null)
            {
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                Image::make($image)->resize(300, 230)->save($location);
                $model->madarek_image = $filename;
            }
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('bahrebardar/all');
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
        
        $request->user()->authorizeRoles(['admin','manager','programmer','agency']);
        // delete
        $model = Bahrebardar::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('bahrebardar/all');
    }
    
    public function newRequest(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork','agency']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\bahrebardar\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\bahrebardar\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/bahrebardar/all','class'=>'btn-info','icon'=>'book'];


        // load the create form (app/views/bahrebardar/create.blade.php)
        return view("admin.bahrebardar.new_request")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
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
            'greenhouseOwner','ornamentalWork','agency']);
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
           // 'title' => ['required'],
            'ostan' => ['required', 'string'],
            'city' => ['required', 'string'],
            'bakhsh' => ['required', 'string'],
            'mantaghe' => ['nullable', 'string'],
            'roosta' => ['nullable', 'string'],
            'utmLat' => ['nullable', 'string'],
            'utmLang' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'type' => ['required'],
            'masahat' => ['required'],
            'malekiyat_id' => ['required'],
            'madarek_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('bahrebardar/new')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $ty = HandyValue::find(Input::get('type'));
            $model = new Location;
            $model->title = 'ملک '.$ty->title.' '.Auth::user()->name;
            $model->user_id = Auth::id();
            $model->ostan_id = Input::get('ostan');
            $model->city_id = Input::get('city');
            $model->bakhsh = Input::get('bakhsh');
            $model->mantaghe = Input::get('mantaghe');
            $model->roosta = Input::get('roosta');
            $model->utmLat = Input::get('utmLat');
            $model->utmLang = Input::get('utmLang');
            $model->address = Input::get('address');
            $model->status = 0;
            $model->type_id = 151;
            $model->save();
            $model->code = 'b-'.$model->id;
            $model->save();

            $bahre = new Bahrebardar;
            $bahre->location_id = $model->id;
            $bahre->num_pahne = 0;
            $bahre->type_id = Input::get('type');
            $bahre->masahat = Input::get('masahat');
            $bahre->malekiyat_id = Input::get('malekiyat_id');

            $image = $request->file('madarek_image');
            if($image != null)
            {
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('image/bahrebaran/' . $filename);
                Image::make($image)->resize(300, 230)->save($location);
                $bahre->madarek_image = $filename;
            }
            $bahre->save();
            
            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('bahrebardar/list');
        }
    }
    
    public function listBah(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','orchardist','planter',
            'greenhouseOwner','ornamentalWork','agency']);
    	// get all the bahrebardar
    	$model = Location::where('type_id',151)->where('user_id',Auth::id())->get();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\bahrebardar\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\bahrebardar\create','class'=>'btn-success','icon'=>'pencil'];
        
        $query = Location::join('cities','cities.id', '=', 'locations.city_id')
                ->join('ostans','cities.ostan_id', '=', 'ostans.id')
                ->where('type_id',151)->where('user_id',Auth::id());
        $Grid = new Grid($query, 'locations');
    	
        $Grid->fields([
            'tbl_locations.title'=>trans('validation.attributes.title'),
          //  'type_id'=>trans('validation.attributes.type'),
            'ostan_id'=>[
                'label'=>trans('validation.attributes.ostan'),
                'field'=>"tbl_ostans.title"
            ],
            'city_id'=>[
                'label'=>trans('validation.attributes.city'),
                'field'=>"tbl_cities.title"
            ]
        ])->processLine(function($row){
            
            $bah = Bahrebardar::where('location_id',$row['id'])->first();
       //     $type = HandyValue::find($bah->type_id);
        //    $row['type_id'] = $type->title;
            
             
            return $row; 
        })->actionFields([
            'tbl_locations.id' //The fields used for process actions. those not are showed 
        ]);
        
     //   $Grid->action(trans('validation.attributes.edit'), '{id}/edit');
        
        // load the view and pass the bahrebardar
    	return view("admin.bahrebardar.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid,
            'tab'=>100
        ]);
    }
}
