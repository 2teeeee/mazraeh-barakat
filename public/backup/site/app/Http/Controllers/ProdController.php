<?php

namespace App\Http\Controllers;
use View;

use App\Helpers\Sms;

use Auth;
use App\Models\Prod;
use Cart;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProdController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function addToCard($id,$numb = 1)
    {
        $prod = Prod::where('id',$id)->first();
        Cart::add($prod->id, $prod->title, $prod->price, $numb, array('image'=>$prod->image));
        return Redirect::to('prod/cart/');
    }
    
    public function incCard()
    {
        $id = Input::get('id');     
        $numb = Input::get('numb');     
        $cart = Cart::get($id);
        $n = $numb - $cart->quantity;
        
        Cart::update($id, array(
            'quantity' => $n, // so if the current prod has a quantity of 4, another 2 will be added so this will result to 6
        ));
        
        return Cart::getTotal();
    }
    
    public function removeCard($id)
    {
        Cart::remove($id);
        return back();
    }
    
    public function cart()
    {
        return View('prod.cart');
    }
    
    public function getAddress()
    {
        return View('prod.getAddress');
    }
    
    public function recipt()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
//            'name' => 'required',
//            'tel' => 'required',
//            'address' => 'required'
        //    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('prod/recipt')
                ->withErrors($validator)->withInput();
        } else {
            try {
                $model = new Invoice;
                $model->name = Input::get('name');
                $model->tel = Input::get('tel');
                $model->address = Input::get('address');
                $model->status = 0;
                $model->code = time();
                $model->user_id = auth::id();
                $model->save();

                foreach(Cart::getContent() as $item) {
                    $nitem = new InvoiceItem();
                    $nitem->invoice_id = $model->id;
                    $nitem->prod_id = $item->id;
                    $nitem->numb = $item->quantity;
                    $nitem->price = $item->price;
                    $nitem->save();
                }
                
                Sms::sendSMS('سفارش شما با موفقیت ثبت شد.'."\n".'http://www.shirazhp.ir','+98500012999001775',$model->tel);
            
                Sms::sendSMS('سفارش جدیدی ثبت شده است.','+98500012999001775','09353173069');
           
                Cart::clear();

                Session::flash('message', trans('validation.success_save'));
                return Redirect::to('prod/end/'.$model->id);
                
            } catch (Exception $e) {
                report($e);
                
                Session::flash('error', trans('validation.erroe_save'));
            }
        }
        
        return Redirect::to('prod/getAdress');
    }
    
    public function endRecipt($id)
    {
        $model = Invoice::where('id',$id)->first();
        
        return View('prod.recipt')->with(['model'=>$model]);
    }
    public function endSale()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'dargah' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('prod/cart')
                ->withErrors($validator)->withInput();
        }
    }
}
