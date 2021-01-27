<?php
namespace App\Helpers;
use nusoap_client;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sms
 *
 * @author user
 */
class Sms {
    
    public static function credit()
    {
        $uname = 'jahadapp'; // Your panel username
	$pass  = 'qazwsxedc'; // Your panel password
      //  $senderNumber = '+9810009177328894';
        $senderNumber = '+985000144411';
        
        $client = new nusoap_client('http://www.smsmelli.com/class/sms/wssimple/server.php?wsdl');
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;
        
        return $client->call("GetCredit", array('Username' => $uname, 'Password' => $pass));
    }
    
    public static function sendSMS($Message, $Receptors, $type = 'normal')
    {
            $uname = 'jahadapp'; // Your panel username
            $pass  = 'qazwsxedc'; // Your panel password
        	$senderNumber = '+985000144411';
            if(is_array($Receptors))
            {
                $i = sizeOf($Receptors);

                while($i--)
                {
                    $Receptors[$i] =  self::CorrectNumber($Receptors[$i]);
                }
            }
            else
            {
                $Receptors = array(self::CorrectNumber($Receptors));
            }
		
		$parameters = array(
			'uname'=> $uname,
			'pass'=> $pass,
			'from'=>$senderNumber,
			'to'=>$Receptors,
			'msg'=>$Message,
		);
		$response = self::CallAPI('POST','http://185.4.31.182/class/sms/restful/sendSms_OneToMany.php',json_encode($parameters));

		return $response;
    }
	
	public static function CallAPI($method, $url, $data = false)
	{
		$curl = curl_init();

		switch ($method)
		{
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);

				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}

		// Optional Authentication:
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "username:password");

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($curl);

		curl_close($curl);
	//	print_r($result);
		return json_decode($result,true);
	}
    
    public static function CorrectNumber(&$uNumber)
    {
        $uNumber = Trim($uNumber);
        $ret = &$uNumber;

        if (substr($uNumber,0, 3) == '%2B')
        { 
                $ret = substr($uNumber, 3);
                $uNumber = $ret;
        }

        if (substr($uNumber,0, 3) == '%2b')
        { 
                $ret = substr($uNumber, 3);
                $uNumber = $ret;
        }

        if (substr($uNumber,0, 4) == '0098')
        { 
                $ret = substr($uNumber, 4);
                $uNumber = $ret;
        }

        if (substr($uNumber,0, 3) == '098')
        { 
                $ret = substr($uNumber, 3);
                $uNumber = $ret;
        }


        if (substr($uNumber,0, 3) == '+98')
        { 
                $ret = substr($uNumber, 3);
                $uNumber = $ret;
        }

        if (substr($uNumber,0, 2) == '98')
        { 
                $ret = substr($uNumber, 2);
                $uNumber = $ret;
        }

        if(substr($uNumber,0, 1) == '0')
        { 
                $ret = substr($uNumber, 1);
                $uNumber = $ret;
        }  

        return '+98' . $ret;
    }

}
