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

        $client = new nusoap_client('http://www.smsmelli.com/class/sms/wssimple/server.php?wsdl');
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;
        
        return $client->call("GetCredit", array('Username' => $uname, 'Password' => $pass));
    }
    
    public static function sendSMS($Message, $SenderNumber, $Receptors, $type = 'normal')
	{
            $uname = 'jahadapp'; // Your panel username
            $pass  = 'qazwsxedc'; // Your panel password

            $client = new nusoap_client('http://www.smsmelli.com/class/sms/wssimple/server.php?wsdl');
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = FALSE;
            
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

            $params = array(
                'Username' => $uname,
                'Password' => $pass,
                'RecipientNumbers' => $Receptors,
                'SenderNumber'=> $SenderNumber,
                'Message' => $Message,
                'Type' => $type
            );

            $response = $client->call("SendSMS", $params);

            return $response;
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