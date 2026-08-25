<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'no_hp',
        'saldo',
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];
}
