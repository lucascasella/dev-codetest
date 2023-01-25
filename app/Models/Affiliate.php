<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    public $affiliate_id;
    public $name;
    public $latitude;
    public $longitude;
    public $distance;

    public function __construct(array $data = array())
    {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
