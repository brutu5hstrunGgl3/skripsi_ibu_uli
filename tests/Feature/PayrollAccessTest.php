<?php

namespace Tests\Feature;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_karyawan_can_access_their_own_payroll_page(): void
    {
        $user = User::factory()->create();
        $payroll = Payroll::factory()->create([
            'user_id' => $user->id,
            'gaji_pokok' => 1500000,
            'jumlah_gaji' => 1500000,
            'jenis_gaji' => 'Transfer Bank',
            'periode_awal' => '2026-08-01',
            'periode_akhir' => '2026-08-31',
            'status' => 'Diproses',
        ]);

        $response = $this->actingAs($user)->get(route('payroll.index'));

        $response->assertStatus(200);
        $response->assertSee($payroll->user->name);
    }
}
