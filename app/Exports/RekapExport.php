<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapExport implements FromArray, WithHeadings
{
    protected array $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'NIS', 'Nama', 'Kelas', 'Total Pertemuan', 'Hadir', 'Sakit', 'Izin', 'Alpa', 'Persentase (%)',
            'Total Tugas', 'Count Tugas', 'Count Ulangan', 'Count UTS', 'Count UAS', 'Rata-rata Nilai', 'Tertinggi', 'Terendah'
        ];
    }
}
