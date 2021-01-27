<?php

namespace App\Http\Controllers;
use nusoap_client;

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

class SepBankController extends Controller
{
    public $MerchantID = "12051401";
    
//    static function encrypt_pkcs7($str, $key)
//    {
//        $key = base64_decode($key);
//        $ciphertext = OpenSSL_encrypt($str,"DES-EDE3", $key, OPENSSL_RAW_DATA);
//        return base64_encode($ciphertext);
//    }
//    static function CallAPI($url, $data = false)
//    {
//        $curl = curl_init($url);
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");  
//        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
//        $result = curl_exec($curl);
//        curl_close($curl);
//        return $result;
//    }

    public function pay($id)
    {
		
        $req = RequestPay::find($id);
        
        $payment = new Payment;
        $payment->bank_id = 180;
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
        
        $valuePay = $req->price;
        
        $MerchantId = $this->MerchantID;
        $Amount = $payment->price; //Rials
        $OrderId = $payment->orderCode;
        $ReturnUrl = 'https://mazraeh-barakat.ir/sepcheck/Verify.php';

        /*
        $client = new nusoap_client('https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL');
        
        $result = $client->call("RequestToken", [
                                        $MerchantId,			/// MID 
                                        $OrderId, 		/// ResNum
                                        $Amount, 			/// TotalAmount
                                        '0',			/// Optional
                                        '0',			/// Optional 
                                        '0',			/// Optional
                                        '0',			/// Optional
                                        '0',			/// Optional
                                        '0',			/// Optional
                                        Auth::user()->name,		/// Optional
                                        Auth::user()->mobile,		/// Optional
                                        '0',			/// Optional
                                        $ReturnUrl //$RedirectURL	/// Optional
                                        ]);
                                        */
      //  echo $result;
      //  return;
        return view("sep.pay")->with([
            'MID' => $MerchantId, 
            'ResNum' => $OrderId,
            'Amount' => $Amount,
            'ResNum1' => Auth::user()->name,
            'ResNum2' => Auth::user()->mobile,
            'ReturnUrl' => $ReturnUrl
        ]);
        
    }
    
    public function verify()
    {
        
        $State = Input::get("State");
        $StateCode = Input::get("StateCode");
        $ResNum = Input::get("ResNum");
        $MID = Input::get("MID");
        $RefNum = Input::get("RefNum");
        $CID = Input::get("CID");
        $TRACENO = Input::get("TRACENO");
        $SecurePan = Input::get("SecurePan");

        $pay = null;
        $message = '';
        $status = 0;

        if($StateCode == 0)
        {
            $checkPay = Payment::where('transactionRef',$RefNum)->first();
            if($checkPay == null)
            {
                $soapclient = new nusoap_client('https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL','wsdl');
                $soapProxy = $soapclient->getProxy() ;
                $result =  $soapclient->verifyTransaction($RefNum,$MID);
print_r($result);
		return;
			
                if( $result <= 0 )
                {
                    var_dump($result);
                    $message = $result;
                    $status = 0;
                }   
                else
                {
                    $pay = Payment::where('orderCode',$ResNum)->first();
                    if($pay->price == $result)
                    {
                        if($pay->status == 0)
                        {
                            $pay->status = 1;
                            $pay->transactionCode = $TRACENO;
                            $pay->transactionTime = time();
                            $pay->cartTransaction = $SecurePan;
                            $pay->transactionRef = $RefNum;
                            $pay->save();

                            $bagPay = BagPay::where('payment_id',$pay->id)->first();
                            $bagPay->status = 1;
                            $bagPay->save();

                            $reqPay = RequestPay::where('bag_pay_id',$bagPay->id)->first();
                            $reqPay->status = 1;
                            $reqPay->save();

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

                            $message = 'تراکنش با موفقیت انجام شد.';
                            $status = 1;

                        }
                        else
                        {
                            $message = 'این درخواست قبلا تایید شده است.';
                            $status = 0;
                        }
                    }
                    else
                    {
                        $client = new nusoap_client('https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL');
                        $result = $client->call("reverseTransaction", [
                                $RefNum,           
                                $MID,
                                "1676405",
                                "@Sep1234"
                            ]);


                        $message = 'مبلغ تراکنش اشتباه می باشد.';
                        $status = 0;
                    }
                    
                }
                
            }
            else
            {
                $message = 'این تراکنش قبلا ثبت شده است.';
                $status = 0;
            }
        }
        else
        {
            $message = 'تراکنش نا موفق می باشد.';
            $status = 0;
        }
        
        return view("sep.verify")->with([
            'pay' => $pay,
            'message' => $message,
            'status' => $status
        ]);
    }

    public function back()
    {
        return view("sep.back");
    }
}