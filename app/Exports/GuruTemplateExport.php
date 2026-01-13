<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GuruTemplateExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{

    public function array(): array
    {
        return [
            [
                'Budi Santoso',
                '000000',
                'Laki-laki',
                'budi@example.com'
            ]
        ];
    }

       public function headings(): array
    {
        return [
            'nama_guru',
            'nip',
            'jenis_kelamin',
            'email'
        ];
    }

    /**
     * Judul Sheet di Excel
     */
    public function title(): string
    {
        return 'Template Guru';
    }
}
