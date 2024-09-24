<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $fillable = [
        'id_user',
        'foto',
        'kehadiran',
        'tanggal_masuk',
        'file',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
