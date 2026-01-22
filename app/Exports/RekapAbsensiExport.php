<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapAbsensiExport implements FromArray, WithHeadings, WithStyles
{
    protected $absensiData;

    public function __construct($absensiData)
    {
        $this->absensiData = $absensiData;
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->absensiData as $absensi) {
            // Group by kelas if multiple classes
            $kelasName = $absensi->kelas?->nama_kelas ?? 'Tidak Diketahui';
            $tanggal = $absensi->tanggal?->format('d-m-Y') ?? '-';
            $guru = $absensi->guru?->name ?? '-';
            $mapel = $absensi->mapel?->nama ?? '-';
            $jampel = $absensi->jampel?->jam_mulai . ' - ' . $absensi->jampel?->jam_akhir ?? '-';

            // Get detail absensi
            foreach ($absensi->detailAbsensi ?? [] as $detail) {
                $siswa = $detail->siswa;
                $rows[] = [
                    'Tanggal' => $tanggal,
                    'Kelas' => $kelasName,
                    'Mapel' => $mapel,
                    'Guru' => $guru,
                    'Jam' => $jampel,
                    'NIS' => $siswa?->nis ?? '-',
                    'Nama Siswa' => $siswa?->nama_siswa ?? '-',
                    'Status' => ucfirst($detail->status ?? 'alpha'),
                    'Keterangan' => $detail->keterangan ?? '-',
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kelas',
            'Mata Pelajaran',
            'Guru',
            'Jam Pelajaran',
            'NIS',
            'Nama Siswa',
            'Status',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563EB'], // Blue-600
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ],
        ];
    }
}
