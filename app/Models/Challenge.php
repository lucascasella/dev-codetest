<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    public static function distancia($lat1, $lng1, $lat2, $lng2) {

        $lat1Rad = $lat1 * pi() / 180;
        $lat2Rad = $lat2 * pi() / 180;
        $lng1Rad = $lng1 * pi() / 180;
        $lng2Rad = $lng2 * pi() / 180;
        
        $dist = (acos(COS($lat1Rad) * COS($lng1Rad) * COS($lat2Rad) * COS($lng2Rad) + COS($lat1Rad) * SIN($lng1Rad) * COS($lat2Rad) * SIN($lng2Rad) + SIN($lat1Rad) * SIN($lat2Rad)) * 6371);
        
        return $dist;
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
