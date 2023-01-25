<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Affiliate;

class AffiliateDistanceTest extends TestCase
{
    /** @test */
    public function check_if_formula_is_correct()
    {
        $affiliate = new Affiliate([
            "latitude" => "52.986375",
            "affiliate_id" => 12,
            "name" => "Yosef Giles",
            "longitude" => "-6.043701"
        ]);

        $distance = $affiliate->distance(53.3340285,-6.2535495);

        $expected = 41.111;
        
        $this->assertEquals($distance, $expected);
    }
}
