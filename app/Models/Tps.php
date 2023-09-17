<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pemilih;

class Tps extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'tps';

    public function pemilih()
    {
        return $this->hasMany(Pemilih::class, 'tps_id', 'id', 'name')->where('is_active', 1);
    }
}
