<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Leader;


class Pemilih extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'pemilih';

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'name');
    }

    public function leader()
    {
        return $this->belongsTo(Leader::class, 'leader_id', 'id', 'name');
    }

    public function mayor()
    {
        return $this->belongsTo(User::class, 'mayor_id', 'id', 'name');
    }

    public function kapten()
    {
        return $this->belongsTo(User::class, 'kapten_id', 'id', 'name');
    }
}
