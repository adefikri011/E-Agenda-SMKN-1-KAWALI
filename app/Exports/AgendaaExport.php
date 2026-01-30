<?php

namespace App\Exports;

use App\Models\Agenda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AgendaaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $agendas;

    public function __construct($agendas)
    {
        $this->agendas = $agendas;
    }

    public function collection()
    {
        return $this->agendas;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Hari',
            'Kelas',
            'Guru',
            'NIP',
            'Mata Pelajaran',
            'Jam Mulai',
            'Jam Selesai',
            'Materi',
            'Kegiatan',
            'Status',
            'Catatan'
        ];
    }

    public function map($agenda): array
    {
        return [
            \Carbon\Carbon::parse($agenda->tanggal)->format('d/m/Y'),
            \Carbon\Carbon::parse($agenda->tanggal)->isoFormat('dddd'),
            $agenda->kelas->nama_kelas ?? '-',
            $agenda->user->guru->nama ?? $agenda->user->name ?? '-',
            $agenda->user->guru->nip ?? '-',
            $agenda->mapel->nama ?? ($agenda->mata_pelajaran ?? '-'),
            $agenda->startJampel ? \Carbon\Carbon::parse($agenda->startJampel->jam_mulai)->format('H:i') : '-',
            $agenda->endJampel ? \Carbon\Carbon::parse($agenda->endJampel->jam_selesai)->format('H:i') : '-',
            $agenda->materi ?? '-',
            $agenda->kegiatan ?? '-',
            $this->getStatusLabel($agenda->status),
            $agenda->catatan ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE8E8E8']
                ]
            ],
        ];
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'approved' => 'Disetujui'
        ];

        return $labels[$status] ?? $status;
    }
}
