<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KelasTemplateExport implements FromArray, WithHeadings
{
    /**
     * Return empty array — template has only headings
     *
     * @return array
     */
    public function array(): array
    {
        return [];
    }

    /**
     * Headings for the template file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'nama_kelas',
            'kode_jurusan',
        ];
    }
}
    