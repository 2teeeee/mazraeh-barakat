<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\ProductKoodValue;
use App\Models\Product;
use App\Models\HandyValue;
use App\Models\City;
use Auth;
use Morilog\Jalali;
use Rafwell\Simplegrid\Grid;

class ProductKoodValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.info.user');
    }
    
    public function all(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer','managerJahad','takhsis']);
        
        $crumb[0] = ['title'=>'صفحه اصلی','url'=>'profile/index.html','class'=>''];
        $crumb[1] = ['title'=>'مدیریت','url'=>'productKoodValue/all','class'=>'active'];

        $btn[0] = ['title'=>'جدید','url'=>"productKoodValue/create",'class'=>'btn-success','icon'=>'pencil'];
        
        if(Auth::user()->hasRole('managerJahad'))
        {
            $query = ProductKoodValue::join('products','products.code','=','product_kood_values.productCode_id')
                ->join('handy_values as koodType','koodType.id','=','product_kood_values.koodType_id')
                ->join('handy_values as abType','abType.id','=','product_kood_values.abType_id')
                ->join('cities as city','city.ct_id','=','product_kood_values.ct_id')
                ->where('ct_id',Auth::user()->city->ct_id)
                ->orderBy('id','desc');
        }
        else
        {
            $query = ProductKoodValue::join('products','products.code','=','product_kood_values.productCode_id')
                ->join('handy_values as koodType','koodType.id','=','product_kood_values.koodType_id')
                ->join('handy_values as abType','abType.id','=','product_kood_values.abType_id')
                ->join('cities','cities.ct_id','=','product_kood_values.ct_id')
                ->orderBy('id','desc');
        }
        
        
        $Grid = new Grid($query, 'productKoodValues');
    	
        $Grid->fields([
            'prodName'=>[
                'label'=>'محصول',
                'field'=>"tbl_products.title"
            ],
            'koodType'=>[
                'label'=>'نوع کود',
                'field'=>"tbl_koodType.title"
            ],
            'abType'=>[
                'label'=>'نوع آبیاری',
                'field'=>"tbl_abType.title"
            ],
            'value'=>[
                'label'=>'تعداد ( کیلوگرم )',
                'field'=>"tbl_product_kood_values.value"
            ],
            'city'=>[
                'label'=>'شهرستان',
                'field'=>"tbl_cities.title"
            ],
            'startDate'=>[
                'label'=>'از تاریخ',
                'field'=>"tbl_product_kood_values.startDate"
            ],
            'endDate'=>[
                'label'=>'تا تاریخ',
                'field'=>"tbl_product_kood_values.endDate"
            ],
        ])->actionFields([
            'tbl_product_kood_values.id' //The fields used for process actions. those not are showed 
        ])->processLine(function($row){
            //This function will be called for each row
            $row['startDate'] = $row['startDate']?jdate($row['startDate'])->format("Y/m/d"):"";
            $row['endDate'] = $row['endDate']?jdate($row['endDate'])->format("Y/m/d"):"";
            //Do more you need on this row
            return $row; //Do not forget to return the row
        });
        
        $Grid->
//                action(trans('validation.attributes.edit'), url('productKoodValue/{id}/edit'),[
//            'icon' => 'fas fa-edit',
//            'onlyIcon' => true ])
//            ->
                action(trans('validation.attributes.delete'), '{id}', [
                'confirm'=>trans('validation.attributes.Do_you_with_so_continue?'),
                'method'=>'DELETE',
                'icon'=>'fas fa-trash-alt',
                'onlyIcon'=>true
            ]);
        
        // load the view and pass the productKoodValue
    	return view("admin.productKoodValue.all")->with([
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
        $crumb[1] = ['title'=>'مدیریت','url'=>'productKoodValue/all','class'=>''];
        $crumb[2] = ['title'=>'جدید','url'=>'','class'=>'active'];

        $btn[0] = ['title'=>'مدیریت','url'=>'productKoodValue/all','class'=>'btn-info','icon'=>'book'];
        
        $products = Product::where('category_id',1)->whereNotNull('code')->get();
        $abTypes = HandyValue::where('handy_id',2)->get();
        $koodTypes = HandyValue::where('handy_id',21)->get();
        if(Auth::user()->hasRole('managerJahad'))
        {
            $cities = City::where('id',Auth::user()->id)->get();
        }
        else
        {
            $cities = City::all();
        }
        

        // load the create form (app/viewsproductKoodValue/create.blade.php)
        return view("admin.productKoodValue.create")->with([
            "crumb"=>$crumb,
            "btn"=>$btn,
            "products" => $products,
            "abTypes" => $abTypes,
            "koods" => $koodTypes,
            "cities" => $cities
        ]);
    }

	/**
     * ProductKoodValue a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin','manager','programmer']);
     
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'product_id' => ['required'],
            'kood_id' => ['required'],
            'abType' => ['required'],
            'city_id' => ['required'],
            'startDate' => ['required'],
            'endDate' => ['required'],
            'value' => ['required'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('productKoodValue/create')
                ->withErrors($validator)->withInput();
        } else {
            $model = new ProductKoodValue;
            $model->productCode_id = Input::get("product_id");
            $model->koodType_id = Input::get("kood_id");
            $model->abType_id = Input::get("abType");
            $model->ct_id = Input::get("city_id");
            $model->startDate = Input::get("startDate");
            $model->endDate = Input::get("endDate");
            $model->value = Input::get("value");
            
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_save'));
            return Redirect::to('productKoodValue/all');
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
     
        // get the productKoodValue
        $model = ProductKoodValue::find($id);

        // show the view and pass the productKoodValue to it
        return View('admin.productKoodValue.show')->with(
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
     
        // get the productKoodValue
        $model = ProductKoodValue::find($id);
        
        
        $btn[0] = ['title'=>'مدیریت','url'=>'productKoodValue/all','class'=>'btn-info','icon'=>'book'];
        $btn[1] = ['title'=>'جدید','url'=>'productKoodValue/create','class'=>'btn-success','icon'=>'pencil'];
        
        // show the edit form and pass the productKoodValue
        return View('admin.productKoodValue.edit')->with([
            'model'=>$model,
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
            'title' => ['required'],
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('productKoodValue/' . $id . '/edit')
                ->withErrors($validator)->withInput();
        } else {
            // productKoodValue
            $model = ProductKoodValue::find($id);
            $model->title = Input::get('title');
            $model->save();

            // redirect
            Session::flash('message', trans('validation.attributes.success_update'));
            return Redirect::to('productKoodValue/all/'.$model->handy_id);
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
        $model = ProductKoodValue::find($id);
        $model->delete();

        // redirect
        Session::flash('message', trans('validation.attributes.success_delete'));
        return Redirect::to('productKoodValue/all');
    }
}
