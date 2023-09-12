<?php

namespace App\Exports;

use App\Models\Dpt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DptExport implements 
FromCollection, 
WithHeadings, 
WithMapping, 
ShouldAutoSize, 
// WithColumnWidths,
WithStyles

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return ["NO", "NAMA", "NAMA TPS", "ADMIN"];
        // return ["NO", "NAMA", "NIK", "NAMA TPS", "ADMIN"];
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
        return Dpt::where('is_active', 1)->with(['admin'])->get();
    }

    private $rowNumber = 0;
    public function map($row):array
    {
        // dd($row->namaDesa);
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->nama,
            // $row->nik,
            $row->namaTps . ', ' . 'Desa ' . $row->namaDesa . ', ' .  'Kecamatan ' . $row->namaKecamatan,
            $row->admin->name
        ];
    }
}
