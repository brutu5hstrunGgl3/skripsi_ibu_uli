<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'user_id',
        'tgl_masuk',
        'tgl_pulang',
        'jam_masuk',
        'jam_pulang',
        'shift',
        'keterlambatan',
    ];

    protected $casts = [
        'tgl_masuk' => 'date',
        'tgl_pulang' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
