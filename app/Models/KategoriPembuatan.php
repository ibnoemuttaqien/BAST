<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPembuatan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pembuatan';

    protected $fillable = [
        'nama',
    ];
}
