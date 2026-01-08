<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Kelas;

class TemplateController extends Controller
{
    /**
     * Generate and download a template for siswa import.
     * If PhpSpreadsheet is available, produce an .xlsx with two sheets:
     *  - Template (headers + example)
     *  - Daftar Kelas (id, nama_kelas)
     * Otherwise fallback to a CSV download that includes kelas list below.
     */
    public function downloadSiswaTemplate(Request $request)
    {
        $kelas = Kelas::select('id', 'nama_kelas')->orderBy('id')->get();

        // If PhpSpreadsheet is installed, produce .xlsx
        if (class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

            // Template sheet
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Template');
            $sheet->fromArray(['nis', 'nama_siswa', 'jenkel', 'nama_kelas'], null, 'A1');
            $sheet->fromArray([['123456', 'Contoh Siswa', 'L', 'X TKJ A']], null, 'A2');

            // Kelas sheet
            $sheetKelas = $spreadsheet->createSheet();
            $sheetKelas->setTitle('Daftar Kelas');
            $sheetKelas->fromArray(['id', 'nama_kelas'], null, 'A1');
            $row = 2;
            foreach ($kelas as $k) {
                $sheetKelas->setCellValue("A{$row}", $k->id);
                $sheetKelas->setCellValue("B{$row}", $k->nama_kelas);
                $row++;
            }

            $tmpPath = tempnam(sys_get_temp_dir(), 'siswa_xlsx_');
            // Ensure correct extension
            $xlsxPath = $tmpPath . '.xlsx';

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($xlsxPath);

            return response()->download($xlsxPath, 'siswa_template.xlsx')->deleteFileAfterSend(true);
        }

        // Fallback: return CSV directly (no ZIP) with kelas list appended
        $csvHeaders = "nis,nama_siswa,jenkel,nama_kelas\n";
        $csvExample = "123456,Contoh Siswa,L,X TKJ A\n\n";

        $lines = [$csvHeaders, $csvExample, "# Daftar Kelas (nama_kelas):\n"];
        foreach ($kelas as $k) {
            $lines[] = $k->nama_kelas . "\n";
        }

        $content = implode('', $lines);

        $filename = 'siswa_template.csv';
        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
