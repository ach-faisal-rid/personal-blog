<?php

namespace Modules\Jurnal\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    protected $table = 'jurnals';
    protected $fillable = [
        'judul',
        'penulis',
        'file',
        'description',
        'index_jurnal',
        'jumlah_halaman',
        'publish'
    ];
}
