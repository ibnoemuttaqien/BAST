<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHasil extends Model
{
    use HasFactory;
    protected $table = 'laporan_hasil';

    protected $fillable = [
        'user_id',
        'barang_id',
        'deskripsi',
        'file', // assuming 'file' is the column name
        'created_at', // to ensure timestamps are managed
        'updated_at',
    ];

    /**
     * Get the user that owns the laporan_hasil.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the barang associated with the laporan_hasil.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
