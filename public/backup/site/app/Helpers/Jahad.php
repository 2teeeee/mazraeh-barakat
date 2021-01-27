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
class Jahad {
    
    public static function GetPahneBarheBardarInfo()
    {
        $client = new nusoap_client('http://10.7.234.33/bahrebardaran/PahneServices.asmx?wsdl',true);
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;

        $params = array(
            "username" => "fars",
            "password" => "mmGH6734in",
            "type" => "1",
             "PersonNationalCode" => "2299224246"
        );

        $response = $client->call("GetPahneBarheBardarInfo", $params);

        return $response;
        
    }
    
    public static function GetPahneFarmInfo($cmelli)
    {
        $client = new nusoap_client('http://10.7.234.33/bahrebardaran/PahneServices.asmx?wsdl',true);
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;

        $params = array(
            "username" => "fars",
            "password" => "mmGH6734in",
            "type" => "1",
             "PersonNationalCode" => $cmelli
        );

        $response = $client->call("GetPahneFarmInfo", $params);

        return $response;
        
    }
    

}