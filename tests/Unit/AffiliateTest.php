<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Affiliate;

class AffiliateTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function check_if_affiliate_attribute_is_correct()
    {
        $affiliate = new Affiliate();

        $expected = [
            "latitude",
            "affiliate_id",
            "name",
            "longitude"
        ];

        $arrayCompared = array_diff($expected, $affiliate->getFillable());
        
        $this->assertEquals(0, count($arrayCompared));
    }
}
