<?php

namespace App\Exports;

use Illuminate\Contracts\Collection as CollectionContract;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class AgendaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $agendas;

    public function __construct($agendas)
    {
        $this->agendas = $agendas;
    }

    public function collection(): Collection
    {
        $rows = [];

        foreach ($this->agendas as $agenda) {
            $rows[] = [
                $agenda->tanggal ? $agenda->tanggal->format('d/m/Y') : '',
                $agenda->jampel->nama_jam ?? '',
                $agenda->kelas->nama_kelas ?? '',
                $agenda->mata_pelajaran ?? '',
                $agenda->user->name ?? '',
                $agenda->status_ttd ? 'Sudah' : 'Belum',
                // Placeholder for image column; actual image will be inserted via AfterSheet event
                '',
            ];
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam',
            'Kelas',
            'Mata Pelajaran',
            'Pembuat',
            'Status TTD',
            'TTD (Gambar)'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ensure export directory exists
                $exportDir = storage_path('app/public/exports');
                if (!file_exists($exportDir)) {
                    mkdir($exportDir, 0755, true);
                }

                // Start from row 2 (row 1 is headings)
                $row = 2;
                foreach ($this->agendas as $agenda) {
                    if (!empty($agenda->tanda_tangan) && strpos($agenda->tanda_tangan, 'base64') !== false) {
                        // Extract base64 data
                        $parts = explode(',', $agenda->tanda_tangan);
                        $data = end($parts);
                        $imagePath = $exportDir . DIRECTORY_SEPARATOR . 'ttd_' . $agenda->id . '.png';
                        file_put_contents($imagePath, base64_decode($data));

                        $drawing = new Drawing();
                        $drawing->setName('ttd_' . $agenda->id);
                        $drawing->setPath($imagePath);
                        // Place image in column G (7th column)
                        $drawing->setCoordinates('G' . $row);
                        $drawing->setHeight(50);
                        $drawing->setWorksheet($sheet);
                    }

                    $row++;
                }
            }
        ];
    }
}
