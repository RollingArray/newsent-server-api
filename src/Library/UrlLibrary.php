<?php

namespace App\Library;

/**
 * Service.
 */
final class UrlLibrary
{
    
    public function __construct()
    {
        //
    }

    public function fileGetContentsCurl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    function postCurl($url,$key, $headers, $payLoad){
        $json = json_encode($payLoad);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . $key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo 'cURL error: ' . curl_error($ch);
        }
        else
        {
            // cURL executed successfully
            //print_r(curl_getinfo($ch));
        }
        curl_close($ch);
        return $result;
    } 
}