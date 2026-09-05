<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencairan extends Model
{
    use HasFactory;

    protected $table = 'pencairan';

    protected $fillable = [
        'user_id',
        'poin',
        'nominal',
        'metode',
        'tujuan',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'poin' => 'integer',
        'nominal' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function rupiah(int $poin): int
    {
        return $poin * (int) config('smartsite.poin_to_rupiah', 100);
    }
}
