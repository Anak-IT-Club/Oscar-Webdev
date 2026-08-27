<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    use HasFactory;

    protected $table = 'sampah';

    protected $fillable = [
        'nama_sampah',
        'jenis_sampah',
        'poin',
    ];

    protected $casts = [
        'poin' => 'integer',
    ];

    public const JENIS_SAMPAH = [
        'Organik',
        'Non-Organik',
        'B3',
        'Residu',
    ];
}
