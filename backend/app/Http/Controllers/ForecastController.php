<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class ForecastController extends Controller
{
    /*
    * Initialization of the contoller
    *
    */
    public function getAllForecastData($payload, $appId){
        return self::curlGetByCity($payload, $appId);
    }
    public function getMapCoordinatate($payload, $appId){
        return self::curlGetMapCoordinates($payload, $appId);
    }


    public static function curlGetByCity($data, $apiKey){
        $apiUrl = env('APP_API_URL');
        $reqUrl = $apiUrl .'?q='. $data['city_name'] .','. $data['country_code'] .'&appId='. $apiKey;
        // echo $reqUrl;
        $ch = curl_init($reqUrl);
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Access-Control-Allow-Origin: *",
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public static function curlGetMapCoordinates($data, $apiKey){
        $apiUrl = env('APP_API_MAPURL');
        $reqUrl = $apiUrl .'?text='. str_replace(' ', '%20', $data['query']).'&format=json&apiKey='.$apiKey;
        // echo $reqUrl;
        // exit();
        $ch = curl_init($reqUrl);
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Access-Control-Allow-Origin: *",
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}
