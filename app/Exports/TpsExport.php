<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Pemilih;

class TpsExport implements 
FromCollection, 
WithHeadings, 
WithMapping, 
ShouldAutoSize, 
WithStyles
{
    use Exportable;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

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

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $pemilihs =  Pemilih::where('tps_id', $this->id)->get();
        return $pemilihs;
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
