<?php

namespace Tests\Feature;

use App\Http\Controllers\PayrollController;
use Tests\TestCase;

class PayrollCalculationTest extends TestCase
{
    public function test_total_gaji_uses_gaji_pokok_plus_lembur(): void
    {
        $controller = new PayrollController();
        $method = new \ReflectionMethod($controller, 'hitungJumlahGaji');
        $method->setAccessible(true);

        $total = $method->invoke($controller, 1500000, 200000);

        $this->assertSame(1700000.0, $total);
    }

    public function test_lembur_value_is_calculated_from_hours(): void
    {
        $controller = new PayrollController();
        $method = new \ReflectionMethod($controller, 'hitungLemburHariKerja');
        $method->setAccessible(true);

        $totalLembur = $method->invoke($controller, 1500000, 2);

        $this->assertSame(30347.0, $totalLembur);
    }
}
