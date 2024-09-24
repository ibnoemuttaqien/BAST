<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model (opsional)
    protected $table = 'barang';

    // Tentukan kolom mana yang boleh diisi secara massal
    protected $fillable = [
        'nama',
        'deskripsi',
        'ukuran',
        'kategori_pembuatan_id',
        'kategori_grade_id',
        'stok',
    ];

    // Tentukan relasi dengan kategori_pembuatan
    public function kategoriPembuatan()
    {
        return $this->belongsTo(KategoriPembuatan::class, 'kategori_pembuatan_id');
    }

    // Tentukan relasi dengan kategori_grade
    public function kategoriGrade()
    {
        return $this->belongsTo(KategoriGrade::class, 'kategori_grade_id');
    }
}
