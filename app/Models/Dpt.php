<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Dpt extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'dpt';

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'name');
    }
}
