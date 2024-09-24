<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriGrade extends Model
{
    use HasFactory;

    protected $table = 'kategori_grade';

    protected $fillable = [
        'nama',
    ];
}
