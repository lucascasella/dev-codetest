<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = [
        'affiliate_id',
        'name',
        'latitude',
        'longitude',
    ];
    
    public function __construct($data = array())
    {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function distance($lat, $lng)
    {
        $lat1Rad = $this->latitude * pi() / 180;
        $lat2Rad = $lat * pi() / 180;
        $lng1Rad = $this->longitude * pi() / 180;
        $lng2Rad = $lng * pi() / 180;
        
        $dist = (acos(COS($lat1Rad) * COS($lng1Rad) * COS($lat2Rad) * COS($lng2Rad) + COS($lat1Rad) * SIN($lng1Rad) * COS($lat2Rad) * SIN($lng2Rad) + SIN($lat1Rad) * SIN($lat2Rad)) * 6371);
        
        return round($dist, 3);
    }
}
