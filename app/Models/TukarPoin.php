<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TukarPoin extends Model
{
    use HasFactory;

    protected $table = 'tukar_poin';

    protected $fillable = [
        'user_id',
        'hadiah_id',
        'poin_dipakai',
    ];

    protected $casts = [
        'poin_dipakai' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hadiah()
    {
        return $this->belongsTo(Hadiah::class);
    }
}
