<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Desa;

class Kecamatan extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'kecamatan';

    public function jendral()
    {
        return $this->belongsTo(User::class, 'jendral_id', 'id', 'name');
    }

    public function desa()
    {
        return $this->hasMany(Desa::class, 'kecamatan_id', 'id', 'name')->where('is_active', 1);
    }
}
