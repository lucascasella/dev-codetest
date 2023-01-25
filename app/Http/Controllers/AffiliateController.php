<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AffiliateQueryRequest;
use App\Models\Affiliate;

class AffiliateController extends Controller
{
    public static function checkDistance(AffiliateQueryRequest $request){
        
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $scope = $request->scope;
        $affiliateList = self::convertFile($request->affiliateList);
        
        $returnList = [];
        foreach($affiliateList as $affiliate){
            $distance = self::distancia($latitude,$longitude, $affiliate->latitude, $affiliate->longitude);
            if($distance <= $scope){
             
       
                $returnList[] = ["affiliate_id" => $affiliate->affiliate_id, 
                                "name" =>  $affiliate->name, 
                                "latitude" =>  $affiliate->latitude, 
                                "longitude" =>  $affiliate->longitude, 
                                "distance" =>  $distance];
            }
        }
        return $returnList;        
    }

    public static function distancia($lat1, $lng1, $lat2, $lng2) {

        $lat1Rad = $lat1 * pi() / 180;
        $lat2Rad = $lat2 * pi() / 180;
        $lng1Rad = $lng1 * pi() / 180;
        $lng2Rad = $lng2 * pi() / 180;
        
        $dist = (acos(COS($lat1Rad) * COS($lng1Rad) * COS($lat2Rad) * COS($lng2Rad) + COS($lat1Rad) * SIN($lng1Rad) * COS($lat2Rad) * SIN($lng2Rad) + SIN($lat1Rad) * SIN($lat2Rad)) * 6371);
        
        return round($dist, 3);
    }

    public static function convertFile($file){
        $affiliateList = [];
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $temp = json_decode($line);
                if(key_exists("latitude", $temp) && 
                    key_exists("affiliate_id", $temp) &&
                    key_exists("name", $temp) &&
                    key_exists("longitude", $temp))
                {
                    $affiliateList[] = $temp;
                }
            }

            fclose($handle);
        }
        return $affiliateList;   
    }
}
