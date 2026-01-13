<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MapelTemplateExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * Return example data for the template
     */
    public function array(): array
    {
        return [
            // Kelas X
            ['Pendidikan Agama Islam dan Budi Pekerti', 'PAIBU-X', 'X'],
            ['Pendidikan Pancasila', 'PPL-X', 'X'],
            ['Bahasa Indonesia', 'IND-X', 'X'],
            ['Pendidikan Jasmani, Olahraga, dan Kesehatan', 'PJOK-X', 'X'],
            ['Sejarah', 'SEJ-X', 'X'],
            ['Seni dan Budaya', 'SNB-X', 'X'],
            ['Bahasa Sunda', 'SD-X', 'X'],
            ['Matematika', 'MTK-X', 'X'],
            ['Bahasa Inggris', 'ENG-X', 'X'],
            ['Informatika', 'INF-X', 'X'],

            // Kelas XI
            ['Pendidikan Agama Islam dan Budi Pekerti', 'PAIBU-XI', 'XI'],
            ['Pendidikan Pancasila', 'PPL-XI', 'XI'],
            ['Bahasa Indonesia', 'IND-XI', 'XI'],
            ['Matematika', 'MTK-XI', 'XI'],
            ['Bahasa Inggris', 'ENG-XI', 'XI'],

            // Kelas XII
            ['Pendidikan Agama Islam dan Budi Pekerti', 'PAIBU-XII', 'XII'],
            ['Matematika', 'MTK-XII', 'XII'],
            ['Bahasa Inggris', 'ENG-XII', 'XII'],
        ];
    }

    /**
     * Headings for the template file
     */
    public function headings(): array
    {
        return [
            'nama',
            'kode',
            'tingkat'
        ];
    }

    /**
     * Sheet title in Excel
     */
    public function title(): string
    {
        return 'Template Mata Pelajaran';
    }
}
