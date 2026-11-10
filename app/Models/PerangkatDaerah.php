<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerangkatDaerah extends Model
{
    use SoftDeletes;

    protected $table = 'perangkat_daerah';

    protected $fillable = [
        'kode_pd',
        'nama',
        'alamat',
    ];

    public function kendaraanDinas()
    {
        return $this->hasMany(KendaraanDinas::class);
    }
}
