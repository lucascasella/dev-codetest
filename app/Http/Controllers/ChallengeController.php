<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Http\Requests\ChallengeRequest;

class ChallengeController extends Controller
{
    public static function activity(ChallengeRequest $request){
        
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $scope = $request->scope;
        $affiliateList = Challenge::convertFile($request->affiliateList);
        
        $returnList = [];
        foreach($affiliateList as $affiliate){
            $distance = Challenge::distancia($latitude,$longitude, $affiliate->latitude, $affiliate->longitude);
            if($distance <= $scope){
                $returnList[] = ["id" => $affiliate->affiliate_id, 
                                "name" =>  $affiliate->name, 
                                "latitude" =>  $affiliate->latitude, 
                                "longitude" =>  $affiliate->longitude , 
                                "distance" =>  $distance];
            }
        }

        return $returnList;        
    }
}
