<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pemilih;

class leader extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'leaders';

    public function pemilih()
    {
        return $this->hasMany(Pemilih::class, 'leader_id', 'id', 'name');
    }
}


