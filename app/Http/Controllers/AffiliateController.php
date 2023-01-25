<?php

namespace App\Http\Controllers;

use App\Http\Requests\AffiliateQueryRequest;
use App\Models\Affiliate;

class AffiliateController extends Controller
{
    public static function checkDistance(AffiliateQueryRequest $request){
        $affiliateList = self::convertFile($request->affiliateList);
        $returnList = [];

        foreach($affiliateList as $affiliate){
            $objAffiliate = new Affiliate($affiliate);
            
            if($objAffiliate->distance($request->latitude, $request->longitude) <= $request->scope){
                $returnList[] = ["name" => $objAffiliate->name, "affiliate_id" => $objAffiliate->affiliate_id];
            }
        }

        return $returnList;        
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
