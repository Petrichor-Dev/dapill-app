<?php

namespace App\Exports;

use App\Models\Pemilih;
use App\Models\User;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PemilihExport implements 
FromCollection, 
WithHeadings, 
WithMapping, 
ShouldAutoSize, 
WithStyles

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return ["NO", "NAMA", "NIK", "LEADER", "KAPTEN", "MAYOR", "NAMA TPS", "STATUS MEMILIH", "ADMIN"];
    }

    public function styles(Worksheet $sheet)
    {
        // Iterate through each row and set border style
    foreach ($sheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Include empty cells

        foreach ($cellIterator as $cell) {
            $cell->getStyle()->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $cell->getStyle()->getBorders()->getAllBorders()->getColor()->setARGB('000000');
        }
    }

        $styleFont = [
            'font' => [
                'bold' => true,
                'size' => 12
            ]
        ];

        $sheet->getStyle(1)->applyFromArray($styleFont);
        
    }

    public function collection(){
        //get data panglima, admin dan super admin
        $idAtasan = User::whereIn('jabatan_id', [1,2,3])->with(['jabatan'])->get()->pluck(['id'])->toArray();
        
        //get user lalu lihat id nya
        $uid = Auth::user()->id;
        // lalu lihat rolenya
        $userRoleId = User::where('id', $uid)->with(['jabatan'])->first()->toArray()['jabatan']['id'];
        //cek apakah idnya mayor atau bukan
        if($userRoleId === 6){
            array_push($idAtasan, $uid);
            $pemilihs = Pemilih::whereIn('user_id', $idAtasan)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get() ?? '';
                // dd($pemilihs);
        } elseif($userRoleId === 4){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanDesaId = Desa::whereIn('user_id', $idAtasan)->get()->pluck(['id'])->toArray();
            $mayorDesaId = Desa::where('user_id', $uid)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanDesaId, $mayorDesaId);

            $pemilihs = Pemilih::whereIn('desa_id', $arrayResult)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get() ?? '';
        } elseif($userRoleId === 5){
            //ambil semua daftar kecamatan berdasarkan si yang menginput (mayor)
            $atasanKecamatanId = Kecamatan::whereIn('user_id', $idAtasan)->get()->pluck(['id'])->toArray();
            $mayorKecamatanId = Kecamatan::where('user_id', $uid)->get()->pluck(['id'])->toArray();
            $arrayResult = array_merge($atasanKecamatanId, $mayorKecamatanId);

            $pemilihs = Pemilih::whereIn('kecamatan_id', $arrayResult)
                ->with(['admin', 'leader', 'kapten', 'mayor'])
                ->get() ?? '';
        } elseif($userRoleId === 2 || $userRoleId === 3 || $userRoleId === 1){
            $pemilihs = Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])->get() ?? '';
        } else{
            $pemilihs = '';
        }

        return $pemilihs;
        // return Pemilih::with(['admin', 'leader', 'kapten', 'mayor'])->get();
    }

    private $rowNumber = 0;
    public function map($row):array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->nama,
            $row->nik,
            $row->leader->name,
            $row->kapten->name, 
            $row->mayor->name,
            $row->namaTps . ', ' . 'Desa ' . $row->namaDesa . ', ' .  'Kecamatan ' . $row->namaKecamatan,
            $row->status_memilih,
            $row->admin->name
        ];
    }
}