<?php

namespace Tests\Feature;

use App\Http\Controllers\PayrollController;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function test_updating_status_does_not_recalculate_total_gaji_from_lembur_field(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $payroll = Payroll::factory()->create([
            'user_id' => $admin->id,
            'gaji_pokok' => 1500000,
            'lembur' => 100000,
            'bonus' => 0,
            'potongan' => 0,
            'jumlah_gaji' => 1600000,
            'status' => 'Diproses',
            'periode_awal' => '2026-08-01',
            'periode_akhir' => '2026-08-31',
        ]);

        $this->actingAs($admin);

        $request = Request::create('/payroll/' . $payroll->id, 'PUT', [
            'user_id' => $admin->id,
            'gaji_pokok' => 1500000,
            'lembur' => 0,
            'jam_lembur' => 2,
            'no_rek' => null,
            'nama_bank' => null,
            'jenis_gaji' => 'Transfer Bank',
            'hadir' => 20,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
            'bonus' => 0,
            'potongan' => 0,
            'periode_awal' => '2026-08-01',
            'periode_akhir' => '2026-08-31',
            'status' => 'Dibayar',
        ]);

        $controller = new PayrollController();
        $response = $controller->update($request, $payroll);

        $payroll->refresh();

        $this->assertEquals('Dibayar', $payroll->status);
        $this->assertEquals(1530347, $payroll->jumlah_gaji);
        $this->assertEquals(30347, $payroll->lembur);
    }
}
