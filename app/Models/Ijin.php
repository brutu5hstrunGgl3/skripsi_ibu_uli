<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ijin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_ijin',
        'keterangan_ijin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
