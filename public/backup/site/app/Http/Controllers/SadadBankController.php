<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use App\Models\Req;
use App\Models\Payment;
use App\Models\BagPay;
use App\Models\RequestPay;
use App\Models\KoodReq;

use Cart;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Hash;

use Auth;

class SadadBankController extends Controller
{
    public $key = "nsBYWV9K8Q97fwt5UUpv8tiy7CvGZGDo";
    
    static function encrypt_pkcs7($str, $key)
    {
        $key = base64_decode($key);
        $ciphertext = OpenSSL_encrypt($str,"DES-EDE3", $key, OPENSSL_RAW_DATA);
        return base64_encode($ciphertext);
    }
    //Send Data
    static function CallAPI($url, $data = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");  
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
}

    public function pay($id)
    {
        $req = RequestPay::find($id);
        
        $payment = new Payment;
        $payment->bank_id = 179;
        $payment->status = 0;
        $payment->price = $req->price;
        $payment->orderCode = time().rand(1111,9999).$req->id;
     //   $payment->transactionCode = $results['Authority'];
        $payment->save();
        
        $bagPay = new BagPay;
        $bagPay->bag_id = Auth::user()->mainBag()->id;
        $bagPay->payment_id = $payment->id;
        $bagPay->price = $payment->price;
        $bagPay->status = 0;
        $bagPay->typePay_id = 163;
        $bagPay->save();
        
        $req->bag_pay_id = $bagPay->id;
        $req->save();
        
        $valuePay = $req->price * 10;
        
        $MerchantId = "140332697";
        $TerminalId = "24073611";
        $Amount = $valuePay; //Rials
        $OrderId = $payment->orderCode;
        $LocalDateTime = date("m/d/Y g:i:s a");
        $ReturnUrl = 'https://mazraeh-barakat.ir/bankcheck/Verify.php';
        $SignData = $this->encrypt_pkcs7("$TerminalId;$OrderId;$Amount","$this->key");
        $data = array('TerminalId'=>$TerminalId,
                    'MerchantId'=>$MerchantId,
                    'Amount'=>$Amount,
                    'SignData'=> $SignData,
                    'ReturnUrl'=>$ReturnUrl,
                    'LocalDateTime'=>$LocalDateTime,
                    'OrderId'=>$OrderId,
                    'UserId' => Auth::user()->mobile);
        $str_data = json_encode($data);
        $res = $this->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest',$str_data);
        $arrres=json_decode($res);
        if($arrres->ResCode==0)
        {
                $Token= $arrres->Token;
                $url="https://sadad.shaparak.ir/VPG/Purchase?Token=$Token";
                return Redirect::to($url);
        }
        else
                die($arrres->Description);
        
        
    }
    
    public function verify()
    {
        
        $OrderId = Input::get("OrderId");
        $Token = Input::get("token");
        $ResCode = Input::get("ResCode");
        $arrres = null;
        if($ResCode == 0)
        {
            $verifyData = array('Token'=>$Token,'SignData'=>$this->encrypt_pkcs7($Token,$this->key));
            $str_data = json_encode($verifyData);				
            $res = $this->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify',$str_data);
            $arrres = json_decode($res);
        }
             
        $pay = Payment::where('orderCode',$OrderId)->first();
        $bagPay = BagPay::where('payment_id',$pay->id)->first();
        $reqPay = RequestPay::where('bag_pay_id',$bagPay->id)->first();
        $model = null;
//        if($reqPay->req_type == 1)
//            $model = KoodReq::find($reqPay->request_id);
        if($pay != null and $pay->status == 0)
        {
            if($arrres && $arrres->ResCode!=-1 && $arrres->ResCode==0)
            {
                $pay->status = 1;
                $pay->transactionCode = $arrres->RetrivalRefNo;
                $pay->save();
                $pay->transactionTime = $pay->updated_at;
                $pay->save();
                
                $pay->paymentBag->update(['status'=>1]);
                $pay->paymentBag->pay->update(['status'=>1]);
                foreach($reqPay->requestKood as $req):
                    KoodReq::where('id',$req->kood_request_id)->update(['status'=>1]);
                endforeach;
                
                $bagPay = new BagPay;
                $bagPay->bag_id = $pay->paymentBag->id;
                $bagPay->price = $pay->price;
                $bagPay->status = -1;
                $bagPay->typePay_id = 163;
                $bagPay->save();
                
                Cart::clear();
                                
                //Save $arrres->RetrivalRefNo,$arrres->SystemTraceNo,$arrres->OrderId to DataBase
            }
            else
            {
                $pay->status = 0;
                $pay->save();
                $pay->transactionTime = $pay->updated_at;
                $pay->save();
                
                $pay->paymentBag->pay->update(['status'=>2]);
               // echo "تراکنش نا موفق می باشد..";	
            }
        }
        elseif($pay->status != 1)
        {
            $pay->status = 3;
            $pay->save();
            $pay->transactionTime = $pay->updated_at;
            $pay->save();
            
            $pay->paymentBag->pay->update(['status'=>3]);
        }
        
        
        return view("sadad.verify")->with([
            'pay'=>$pay,
            'model'=>$model
        ]);
    }
}
