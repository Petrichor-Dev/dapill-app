<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueActiveName implements Rule
{
    public function passes($attribute, $value)
    {
        // Lakukan pemeriksaan sesuai dengan syarat yang Anda inginkan.
        return DB::table('pemilih')
                  ->where('nama', $value)
                  ->where('is_active', 1)
                  ->count() === 0;
    }

    public function message()
    {
        return 'Nama harus bersifat unik';
    }
}
