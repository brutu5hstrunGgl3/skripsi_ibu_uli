<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollFactory> */
    use HasFactory;

     protected $fillable = [
        'user_id',
        'gaji_pokok',
        'lembur',
        'no_rek',
        'nama_bank',
        'jenis_gaji',
        'hadir',
        'izin',
        'sakit',
        'alpha',
        'potongan',
        'bonus',
        'jumlah_gaji',
        'periode_awal',
        'periode_akhir',
        'status',
    ];
      public function user()
    {
        return $this->belongsTo(User::class);
    }
}
