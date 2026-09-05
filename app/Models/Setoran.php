<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;

    protected $table = 'setoran';

    protected $fillable = [
        'user_id',
        'sampah_id',
        'jenis_sampah',
        'poin',
        'sumber',
        'status',
        'foto',
        'catatan',
    ];

    protected $casts = [
        'poin' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sampah()
    {
        return $this->belongsTo(Sampah::class);
    }
}
