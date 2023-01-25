<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\AffiliateController;

class DistanceTest extends TestCase
{
    /** @test */
    public function check_if_formula_is_correct()
    {
        $distance = AffiliateController::distancia(53.3340285,-6.2535495,53.2451022,-6.238335);

        $expected = 9.94;
        
        $this->assertEquals($distance, $expected);
    }
}
