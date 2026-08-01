<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CutiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_and_view_cuti_records(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->withSession(['_token' => 'test-token'])->post(route('cuti.store'), [
            '_token' => 'test-token',
            'nama' => 'Raja',
            'posisi' => 'Developer',
            'tanggal_mulai' => '2026-08-10',
            'tanggal_selesai' => '2026-08-12',
            'keterangan' => 'Istirahat keluarga',
        ]);

        $response->assertRedirect(route('cuti.index'));

        $this->assertDatabaseHas('cutis', [
            'nama' => 'Raja',
            'posisi' => 'Developer',
            'keterangan' => 'Istirahat keluarga',
        ]);

        $viewResponse = $this->actingAs($user)->get(route('cuti.index'));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Raja');
    }
}
