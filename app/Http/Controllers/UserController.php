<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\User;

use App\Models\Role;

use App\Models\RoleUser;

use App\Models\Product;

use App\Models\KargozarKoodValue;

use App\Models\City;



use Auth;



use App\Http\Requests;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Session;



use Rafwell\Simplegrid\Grid;



class UserController extends Controller

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



    public function all(Request $request)

    {
        $request->user()->authorizeRoles(['admin', 'manager','nazer']);

    	// get all the user

    	$model = '';

        

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];

        $crumb[1] = ['title'=>'مدیریت','url'=>'\user\all','class'=>'active'];



        $btn[0] = ['title'=>'جدید','url'=>'\user\create','class'=>'btn-success','icon'=>'pencil'];



         $gridQuery = User::join('cities','cities.id','=','users.city_id');

        $Grid = new Grid($gridQuery, 'users');

    	

        $Grid->fields([

            'name'=>trans('validation.attributes.name'),

            'codemelli'=>trans('validation.attributes.codemelli'),

            'tbl_cities.title' => 'شهر',

            'mobile'=>trans('validation.attributes.mobile'),

        ])->actionFields([

            'tbl_users.id' //The fields used for process actions. those not are showed 

        ]);

        

        $Grid->action(trans('validation.attributes.edit'), '{id}/edit',[

                'icon' => 'fas fa-edit',

                'onlyIcon' => true

            ])

            ->action(trans('validation.attributes.delete'), '{id}', [

                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),

                'method'=>'DELETE',

                'icon' => 'fas fa-trash-alt',

                'onlyIcon' => true

            ]);

        

        // load the view and pass the user

    	return view("admin.user.all")->with([

            "model"=>$model,

            "crumb"=>$crumb,

            "btn"=>$btn,

            "grid"=>$Grid

        ]);

    }



    public function kargozar(Request $request)

    {

        $request->user()->authorizeRoles(['admin', 'manager','managerJahad']);

    	// get all the user

    	$model = User::all();

        

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];

        $crumb[1] = ['title'=>'مدیریت','url'=>'\user\all','class'=>'active'];



        $btn = null;



        if(Auth::user()->hasRole('managerJahad'))

        {

            $gridQuery = User::join('role_user','users.id','=','role_user.user_id')

                ->join('cities','cities.id','=','users.city_id')

                ->where('users.city_id',auth::user()->city_id)

                ->where('role_user.role_id',11);

        }

        else

        {

            $gridQuery = User::join('role_user','users.id','=','role_user.user_id')

                ->join('cities','cities.id','=','users.city_id')

                ->where('role_user.role_id',11);

        }

        

        $Grid = new Grid($gridQuery, 'users');

    	

        $Grid->fields([

            'name'=>trans('validation.attributes.name'),

            'company'=>'نام شرکت',

            'tbl_cities.title' => 'شهر',

          'codemelli'=>trans('validation.attributes.codemelli'),

            'mobile'=>trans('validation.attributes.mobile'),

        ])->actionFields([

            'tbl_users.id' //The fields used for process actions. those not are showed 

        ]);

        

        $Grid->action('سهمیه کود', '{id}/koodList',[

                'icon' => 'fas fa-list',

                'onlyIcon' => true

            ])

            ->action(trans('validation.attributes.edit'), '{id}/edit',[

                'icon' => 'fas fa-edit',

                'onlyIcon' => true

            ])

            ->action(trans('validation.attributes.delete'), '{id}', [

                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),

                'method'=>'DELETE',

                'icon' => 'fas fa-trash-alt',

                'onlyIcon' => true

            ]);

        

        // load the view and pass the user

    	return view("admin.user.all")->with([

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

        $request->user()->authorizeRoles(['admin', 'manager']);



        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];

        $crumb[1] = ['title'=>'مدیریت  کاربر ها','url'=>'\user\all','class'=>''];

        $crumb[2] = ['title'=>'کاربر جدید','url'=>'\user\create','class'=>'active'];



     //   $btn[0] = ['title'=>'مدیریت','url'=>'/user/all','class'=>'btn-info','icon'=>'book'];

        $btn = null;

        

        $roles = Role::where('status', '=', 1)->get();



        $citys = City::all();

        // load the create form (app/views/user/create.blade.php)

        return view("admin.user.create")->with([

            "crumb"=>$crumb,

            "btn"=>$btn,

            'roles'=>$roles,

            'citys' => $citys

        ]);

    }



	/**

     * Store a newly created resource in storage.

     *

     * @return Response

     */



    public function store(Request $request)

    {

        $request->user()->authorizeRoles(['admin', 'manager']);

        // validate

        // read more on validation at http://laravel.com/docs/validation

        $rules = array(

            'name' => ['required', 'string', 'max:255'],

            'mobile' => ['required', 'string', 'unique:users'],

            'codemelli' => ['required', 'string', 'unique:users'],

            'email' => ['nullable', 'string', 'max:255'],

            'password' => ['required', 'string', 'min:6'],

            'role' => ['required'],

            'city_id' => ['required']

        );

        $validator = Validator::make(Input::all(), $rules);



        // process the login

        if ($validator->fails()) {

            return Redirect::to('user/create')

                ->withErrors($validator)->withInput();

        } else {

            // store

            $model = new User;

            $model->name = Input::get('name');

            $model->codemelli = Input::get('codemelli');

            $model->uname = Input::get('codemelli');

            $model->password = Hash::make(Input::get('password'));

            $model->mobile = Input::get('mobile');

            $model->email = Input::get('email');

            $model->code = time();

            $model->status = 1;

            $model->address = Input::get('address');

            $model->check_email = 0;

            $model->check_mobile = 0;

            $model->father_name = Input::get('father_name');

            $model->birth_date = Input::get('birth_date');

            $model->level_tahsil = Input::get('level_tahsil');

            $model->reshte_tahsil = Input::get('reshte_tahsil');

            $model->company = Input::get('company');

            $model->city_id = Input::get('city_id');

            $model->ostan_id = 17;

            

            

            $model->save();



            if(Input::get('role') != null)

                foreach (Input::get('role') as $key => $value) {

                    $model->roles()->attach(Role::find($value));

                }



            // redirect

            Session::flash('message', trans('validation.attributes.success_save'));

            return Redirect::to('user/all');

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

        $request->user()->authorizeRoles(['admin', 'manager']);

        // get the user

        $model = User::find($id);



        // show the view and pass the user to it

        return View('admin.user.show')->with(

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

        $request->user()->authorizeRoles(['admin', 'manager','managerJahad']);

        // get the user

        

        $model = User::find($id);

        

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];

        $crumb[1] = ['title'=>'مدیریت  کاربر ها','url'=>'user/all','class'=>''];

        $crumb[2] = ['title'=>'ویرایش '.$model->name,'url'=>'user/create','class'=>'active'];



        $roles = Role::where('status', '=', 1)->get();



        $citys = City::all();

        

      //  $btn[0] = ['title'=>'مدیریت','url'=>'/user/all','class'=>'btn-info','icon'=>'book'];

     //   $btn[1] = ['title'=>'جدید','url'=>'/user/create','class'=>'btn-success','icon'=>'pencil'];

        $btn = null;

        // show the edit form and pass the user

        return View('admin.user.edit')->with([

            'model'=>$model,

            'roles'=>$roles,

            "crumb"=>$crumb,

            'btn'=>$btn,

            'citys' => $citys

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

        $request->user()->authorizeRoles(['admin', 'manager','managerJahad']);

        // validate

        // read more on validation at http://laravel.com/docs/validation

        $rules = array(

            'name' => ['required', 'string', 'max:255'],

            'mobile' => ['required', 'string'],

            'codemelli' => ['required', 'string'],

            'email' => ['nullable', 'string', 'max:255'],

            'role' => ['required'],

            'city_id' => ['required']

        );

        $validator = Validator::make(Input::all(), $rules);



        // process the login

        if ($validator->fails()) {

            return Redirect::to('user/' . $id . '/edit')

                ->withErrors($validator)->withInput();

        } else {

            // store

            $model = User::find($id);

            $model->name = Input::get('name');

            $model->codemelli = Input::get('codemelli');

        //    $model->uname = Input::get('codemelli');

            $model->mobile = Input::get('mobile');

        //    $model->password = Hash::make(Input::get('mobile'));

            $model->email = Input::get('email');

            $model->address = Input::get('address');

            $model->father_name = Input::get('father_name');

            $model->birth_date = Input::get('birth_date');

            $model->level_tahsil = Input::get('level_tahsil');

            $model->reshte_tahsil = Input::get('reshte_tahsil');

            $model->company = Input::get('company');

            $model->city_id = Input::get('city_id');

            $model->ostan_id = 17;

            $model->save();



            $frole = RoleUser::where('user_id','=',$model->id)->delete();

            if(Input::get('role') != null)

                foreach (Input::get('role') as $key => $value) {

                    $model->roles()->attach(Role::find($value));

                }



            // redirect

            Session::flash('message', trans('validation.attributes.success_update'));

            return back();

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

        $request->user()->authorizeRoles(['admin', 'manager']);

        // delete

        $model = User::find($id);

        $model->delete();



        // redirect

        Session::flash('message', trans('validation.attributes.success_delete'));

        return Redirect::to('user/all');

    }

    

    

    public function koodList($id, Request $request)

    {

        $request->user()->authorizeRoles(['admin', 'manager','managerJahad']);



        $model = User::find($id);

        

        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];

        $crumb[1] = ['title'=>'مدیریت  کارگزاران','url'=>'\user\kargozar','class'=>''];

        $crumb[2] = ['title'=>'سهمیه کود '.$model->name,'url'=>'','class'=>'active'];



        $btn[0] = ['title'=>'کارگزاران','url'=>'user/kargozar','class'=>'btn-info','icon'=>'book'];



        $koods = Product::where('category_id', 3)->get();

        $kargozarKood = null;

        foreach ($koods as $value) {

            $karKood = KargozarKoodValue::where('user_id',$id)->where('kood_id',$value->id)->first();

            if($karKood)

                $kargozarKood[$value->id] = ['name'=>$value->title,'value'=>$karKood->value];

            else

                $kargozarKood[$value->id] = ['name'=>$value->title,'value'=>0];

        }



        // load the create form (app/views/user/create.blade.php)

        return view("admin.user.kood_list")->with([

            "crumb" => $crumb,

            "btn" => $btn,

            "model" => $model,

            "kargozarKood" => $kargozarKood

        ]);

    }

    

    public function storeKoodList($id,Request $request)

    {

        $request->user()->authorizeRoles(['admin', 'manager','managerJahad']);

        // validate

        // read more on validation at http://laravel.com/docs/validation

        $rules = array(

            

        );

        $validator = Validator::make(Input::all(), $rules);



        // process the login

        if ($validator->fails()) {

            return Redirect::to('user/' . $id . '/koodList')

                ->withErrors($validator)->withInput();

        } else {

            // store

            $koods = Input::get('kood');

            foreach($koods as $key => $value)

            {

                echo $value;

                $karKood = KargozarKoodValue::where('user_id',$id)->where('kood_id',$key)->first();

                if($karKood)

                    $karKood->value = $value?$value:0;

                else

                {

                    $karKood = new KargozarKoodValue;

                    $karKood->user_id = $id;

                    $karKood->kood_id = $key;

                    $karKood->value = $value;

                }

                    $karKood->save();

            }

            

            // redirect

            Session::flash('message', trans('validation.attributes.success_update'));

            return Redirect::to('user/kargozar');

        }

    }

}