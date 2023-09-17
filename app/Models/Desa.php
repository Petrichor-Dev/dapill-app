<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'desa';

    public function mayor()
    {
        return $this->belongsTo(User::class, 'mayor_id', 'id', 'name')->where('is_active', 1);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id', 'name')->where('is_active', 1);
    }

    public function tps()
    {
        return $this->hasMany(Tps::class, 'desa_id', 'id', 'name')->where('is_active', 1);
    }
}
