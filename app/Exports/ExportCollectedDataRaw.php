<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportCollectedDataRaw implements FromCollection, WithStrictNullComparison, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $form;
    protected $data;
    protected $header;

    public function __construct($form, $data, $header)
    {
        $this->form = $form;
        $this->data = $data;
        $this->header = $header;
    }

    public function collection() {
        return $this->data;
    }

    public function headings(): array {
        return $this->header;
    }

    public function map($data): array {
        
        return collect($data)->pluck('response')->values()->all();
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            //'A' => ['font' => ['bold' => true]],
        ];
    }
}