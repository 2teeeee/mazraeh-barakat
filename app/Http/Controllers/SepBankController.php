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
use App\Models\BrokerKood;
use App\Models\PaymentStat;

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
		
		$parameters = [
			$MerchantId,	
			$OrderId, 		
			$Amount, 			
			'0',		
			'0',		
			'0',		
			'0',		
			'0',		
			'0',		
			Auth::user()->codemelli,	
			Auth::user()->mobile,	
			'0',		
			$ReturnUrl
		];
		
		$client 	= new nusoap_client('https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL','wsdl');
        $result 	= $client->call('RequestToken', $parameters);

        return view("sep.pay")->with([
            'MID' => $MerchantId, 
            'ResNum' => $OrderId,
            'Amount' => $Amount,
            'ResNum1' => Auth::user()->name,
            'ResNum2' => Auth::user()->mobile,
            'ReturnUrl' => $ReturnUrl,
			'result' => $result
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
				
				$newStat = new Paymentstat;
				$newStat->status = -1;
				$newStat->resNum = $ResNum;
				$newStat->user_id = Auth::user()->id;
				$newStat->save();
				
                $soapclient = new nusoap_client('https://acquirer.samanepay.com/payments/referencepayment.asmx?WSDL','wsdl');
                $soapclient->debug_flag=true;
				$soapProxy = $soapclient->getProxy();
				//if( $err = $soapclient->getError() )
			//		echo $err ;
			//	echo $soapclient->debug_str;
                $result =  $soapProxy->verifyTransaction($RefNum,$MID);

                if( $result <= 0 )
                {
                //    var_dump($result);
                    $message = $result;
                    $status = 0;
                }   
                else
                {
                    $pay = Payment::where('orderCode',$ResNum)->first();
					
					$newStat->payment_id = $pay->id;
					$newStat->status = 0;
					$newStat->save();
					
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
                                $koodReq = KoodReq::find($req->kood_request_id);
								$koodReq->payment_id = $pay->id;
								$koodReq->status = 1;
								$koodReq->save();
							
								$new = new BrokerKood;
								$new->broker_id = $koodReq->broker_id;
								$new->kood_id = $koodReq->kood_id;
								$new->value = $koodReq->value;
								$new->tonne = round((($koodReq->value * 50) / 1000),2);
								$new->type = -1;
								$new->user_id = Auth::id();
								$new->comment = 'ثبت درخواست کود '.$koodReq->kood->title.' برای بهره بردار '.$koodReq->user->name;
								$new->save();
							
                            endforeach;
                
                            $bagPayBack = new BagPay;
                            $bagPayBack->bag_id = $bagPay->bag_id;
                            $bagPayBack->payment_id = $bagPay->payment_id;
                            $bagPayBack->price = $bagPay->price;
                            $bagPayBack->status = -1;
                            $bagPayBack->typePay_id = 182;
                            $bagPayBack->save();
							
							$newStat->payment_id = $pay->id;
							$newStat->status = 1;
							$newStat->save();
							
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