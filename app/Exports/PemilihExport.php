<?php

namespace App\Exports;

use App\Models\Pemilih;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemilihExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return ["Nama", "Leader", "Kapten", "Nama Tps", "Staus Memilih", "Admin"];
    }
    
    // public function model(array $row)
    // {
    //     return new User([
    //         'name'  => $row['name'],
    //         'email' => $row['email'],
    //         'at'    => $row['at_field'],
    //     ]);
    // }

    public function collection()
    {
        // dd(Pemilih::get());
        dd(Pemilih::with(['userAdmin', 'leader', 'kapten', 'mayor'])->get());
        return Pemilih::with(['userAdmin', 'leader', 'kapten', 'mayor'])->get();
    }
}
