<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\Location;
use App\Models\LocationInfo;
use App\Models\HandyValue;
use App\Models\City;
use Rafwell\Simplegrid\Grid;
use App\User;
use Image;
use Auth;

class InsectariumController extends Controller
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
        $request->user()->authorizeRoles(['admin','manager','programmer','insectarium']);
        
        return view("admin.insectarium.index")->with([]);
    }
    
    public function all(Request $request)
    {
        
        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
    	// get all the insectarium
    	$model = DafAfat::all();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\insectarium\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\insectarium\create','class'=>'btn-success','icon'=>'pencil'];
        
        $Grid = new Grid(DafAfat::query(), 'insectariums');
    	
        $Grid->fields([
          'name'=>trans('validation.attributes.name'),
          'user_id'=>trans('validation.attributes.user'),
          'num_mojavez'=>trans('validation.attributes.num_mojavez'),
          'ostan'=>trans('validation.attributes.ostan'),
          'city'=>trans('validation.attributes.city'),
          
        ])->actionFields([
            'id' //The fields used for process actions. those not are showed 
        ]);
        
        $Grid->action(trans('validation.attributes.edit'), '{id}/edit')
            ->action(trans('validation.attributes.delete'), '{id}', [
                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
                'method'=>'DELETE',
            ]);
        
        // load the view and pass the insectarium
    	return view("admin.insectarium.all")->with([
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

        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\insectarium\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\insectarium\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/insectarium/all','class'=>'btn-info','icon'=>'book'];

        $users = User::all();

        // load the create form (app/views/insectarium/create.blade.php)
        return view("admin.insectarium.create")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
            'users'=>$users
        ]);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'user_id' => ['required'],
            'num_mojavez' => ['required', 'string'],
            'ostan' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'bakhsh' => ['nullable', 'string'],
            'mantaghe' => ['nullable', 'string'],
            'roosta' => ['nullable', 'string'],
            'utm' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'date_start_mojavez' => ['nullable','string'],
            'date_end_mojavez' => ['nullable','string'],
            'masool_fani' => ['nullable','string'],
            'tel' => ['nullable','string'],
            'num_nezam_mohandesi' => ['nullable','string'],
            'num_shaba' => ['nullable','string'],
            'name' => ['required','string'],
            'level_nezam_mohandesi' => ['nullable','string'],
            'type' => ['required'],
            'image_mojavez' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('insectarium/create')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = new DafAfat;
            $model->user_id = Input::get('user_id');
            $model->num_mojavez = Input::get('num_mojavez');
            $model->ostan = Input::get('ostan');
            $model->city = Input::get('city');
            $model->bakhsh = Input::get('bakhsh');
            $model->mantaghe = Input::get('mantaghe');
            $model->roosta = Input::get('roosta');
            $model->utm = Input::get('utm');
            $model->address = Input::get('address');
            $model->status = 1;
            $model->name = Input::get('name');
            $model->num_shaba = Input::get('num_shaba');
            $model->num_nezam_mohandesi = Input::get('num_nezam_mohandesi');
            $model->tel = Input::get('tel');
            $model->level_nezam_mohandesi = Input::get('level_nezam_mohandesi');
            $model->type = Input::get('type');
            $model->masool_fani = Input::get('masool_fani');
            $model->date_start_mojavez = Input::get('date_start_mojavez');
            $model->date_end_mojavez = Input::get('date_end_mojavez');
            
            $image = $request->file('image_mojavez');
            if($image != null)
            {
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('image/insectarium/' . $filename);
                Image::make($image)->resize(300, 230)->save($location);
                $model->image_mojavez = $filename;
            }
        
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('insectarium/all');
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
        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
        // get the insectarium
        $model = DafAfat::find($id);

        // show the view and pass the insectarium to it
        return View('admin.insectarium.show')->with(
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
        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
        // get the insectarium
        $model = DafAfat::find($id);
        
        $users = User::all();
        
        $btn[0] = ['title'=>'مدیریت','url'=>'/insectarium/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'/insectarium/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the insectarium
        return View('admin.insectarium.edit')->with([
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
        $request->user()->authorizeRoles(['admin','manager','programmer']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'user_id' => ['required'],
            'num_mojavez' => ['required', 'string'],
            'ostan' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'bakhsh' => ['nullable', 'string'],
            'mantaghe' => ['nullable', 'string'],
            'roosta' => ['nullable', 'string'],
            'utm' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'date_start_mojavez' => ['nullable','string'],
            'date_end_mojavez' => ['nullable','string'],
            'masool_fani' => ['nullable','string'],
            'tel' => ['nullable','string'],
            'num_nezam_mohandesi' => ['nullable','string'],
            'num_shaba' => ['nullable','string'],
            'name' => ['required','string'],
            'level_nezam_mohandesi' => ['nullable','string'],
            'type' => ['required'],
            'image_mojavez' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('insectarium/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // store
            $model = DafAfat::find($id);
            
            $model->user_id = Input::get('user_id');
            $model->num_mojavez = Input::get('num_mojavez');
            $model->ostan = Input::get('ostan');
            $model->city = Input::get('city');
            $model->bakhsh = Input::get('bakhsh');
            $model->mantaghe = Input::get('mantaghe');
            $model->roosta = Input::get('roosta');
            $model->utm = Input::get('utm');
            $model->address = Input::get('address');
            $model->status = Input::get('status');
            $model->name = Input::get('name');
            $model->num_shaba = Input::get('num_shaba');
            $model->num_nezam_mohandesi = Input::get('num_nezam_mohandesi');
            $model->tel = Input::get('tel');
            $model->level_nezam_mohandesi = Input::get('level_nezam_mohandesi');
            $model->type = Input::get('type');
            $model->masool_fani = Input::get('masool_fani');
            $model->date_start_mojavez = Input::get('date_start_mojavez');
            $model->date_end_mojavez = Input::get('date_end_mojavez');
            
            $image = $request->file('image_mojavez');
            if($image != null)
            {
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('image/insectarium/' . $filename);
                Image::make($image)->resize(300, 230)->save($location);
                $model->image_mojavez = $filename;
            }
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('insectarium/all');
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
        $model = DafAfat::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('insectarium/all');
    }
    
    public function newRequest(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','insectarium']);
        

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت ;کاربر ها','url'=>'\insectarium\all','class'=>''];
        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\insectarium\create','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'/insectarium/all','class'=>'btn-info','icon'=>'book'];

        $types = HandyValue::where('handy_id',1)->get();

        // load the create form (app/views/insectarium/create.blade.php)
        return view("admin.insectarium.new_request")->with([
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
        $request->user()->authorizeRoles(['admin','manager','programmer','insectarium']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'num_mojavez' => ['required', 'string'],
            'ostan' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'bakhsh' => ['nullable', 'string'],
            'mantaghe' => ['nullable', 'string'],
            'roosta' => ['nullable', 'string'],
            'utm' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'date_start_mojavez' => ['nullable','string'],
            'date_end_mojavez' => ['nullable','string'],
            'masool_fani' => ['nullable','string'],
            'tel' => ['nullable','string'],
            'num_nezam_mohandesi' => ['nullable','string'],
            'num_shaba' => ['nullable','string'],
            'name' => ['required','string'],
            'level_nezam_mohandesi' => ['nullable','string'],
            'type' => ['required'],
            'image_mojavez' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('insectarium/new')
                ->withErrors($validator)->withInput();
        } else {
            // dafafat
            $model = new Location;
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
            $model->title = Input::get('name');
            $model->num_shaba = Input::get('num_shaba');
            $model->tel = Input::get('tel');           
            $model->type_id = 155;
            $model->save();
            $model->code = 'i-'.$model->id;
            $model->save();
            
            $info = new LocationInfo;
            $info->location_id = $model->id;
            $info->num_mojavez = Input::get('num_mojavez');
            $info->num_nezam_mohandesi = Input::get('num_nezam_mohandesi');
            $info->masool_fani = Input::get('masool_fani');
            $info->date_start_mojavez = Input::get('date_start_mojavez');
            $info->date_end_mojavez = Input::get('date_end_mojavez');
            $info->num_pkasb = Input::get('num_pkasb');
            $info->date_start_pkasb = Input::get('date_start_pkasb');
            $info->date_end_pkasb = Input::get('date_end_pkasb');
            
            $image2 = $request->file('image_pkasb');
            if($image2 != null)
            {
                $filename2 = time(). '.' . $image2->getClientOriginalExtension();
                $location2 = public_path('image/store/' . $filename2);
                Image::make($image2)->resize(300, 230)->save($location2);
                $info->image_pkasb = $filename2;
            }
            
            $image = $request->file('image_mojavez');
            if($image != null)
            {
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('image/store/' . $filename);
                Image::make($image)->resize(300, 230)->save($location);
                $info->image_mojavez = $filename;
            }
        
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('insectarium/list');
        }
    }
    
    public function listBah(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','insectarium']);
        
    	// get all the insectarium
    	$model = Location::where('type_id',155)->where('user_id',Auth::id())->get();
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'admin','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'\insectarium\all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>'\insectarium\create','class'=>'btn-success','icon'=>'pencil'];

        $gridQuery = Location::join('users','users.id', '=', 'locations.user_id')
                ->join('cities','cities.id', '=', 'locations.city_id')
                ->join('ostans','cities.ostan_id', '=', 'ostans.id')
                ->where('type_id',155)->where('user_id',Auth::id());
        
        $Grid = new Grid($gridQuery, 'locations');
    	
        $Grid->fields([
          'tbl_locations.title'=>trans('validation.attributes.name'),
            'user_id'=>[
                'label'=>trans('validation.attributes.user'),
                'field'=>"tbl_users.name"
            ],
            'ostan_id'=>[
                'label'=>trans('validation.attributes.ostan'),
                'field'=>"tbl_ostans.title"
            ],
            'city_id'=>[
                'label'=>trans('validation.attributes.city'),
                'field'=>"tbl_cities.title"
            ]
          
        ])->processLine(function($row){
            
            return $row; 
        })->actionFields([
            'tbl_locations.id' //The fields used for process actions. those not are showed 
        ]);
        
     //   $Grid->action(trans('validation.attributes.edit'), '{id}/edit');
        
        // load the view and pass the insectarium
    	return view("admin.insectarium.list")->with([
            "model"=>$model,
            "crumb"=>$crumb,
            "btn"=>$btn,
            "grid"=>$Grid,
            'tab'=>100
        ]);
    }
}
