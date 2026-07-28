<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbsensiExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_download_absensi_export(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Absensi::create([
            'user_id' => $user->id,
            'tgl_masuk' => '2026-07-28',
            'tgl_pulang' => '2026-07-28',
            'jam_masuk' => '08:00:00',
            'jam_pulang' => '17:00:00',
            'shift' => 'Pagi',
            'keterlambatan' => 10,
        ]);

        $response = $this->get(route('absensi.export'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
