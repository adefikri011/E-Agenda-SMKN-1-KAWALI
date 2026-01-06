<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap {{ $kelas ?? '' }}</title>
    <style>
        /* --- General Styles --- */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .print-container {
            max-width: 297mm; /* Lebar A4 Landscape */
            margin: 0 auto;
            padding: 10mm;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }

        .report-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .report-info {
            margin-bottom: 15px;
            font-size: 10px;
            color: #555;
            text-align: center;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto; /* Mencegah tabel melebar di layar kecil */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            background-color: #ffffff;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 6px 5px;
            vertical-align: middle;
        }

        th {
            background-color: #374151;
            color: #ffffff;
            font-weight: 600;
            text-align: center;
            font-size: 9px;
            white-space: nowrap;
            text-transform: uppercase;
        }

        td {
            text-align: center;
        }

        td:nth-child(2), /* NIS */
        td:nth-child(3)  /* Nama */
        {
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tbody tr:hover {
            background-color: #f3f4f6;
        }

        /* --- Print Specific Styles --- */
        @media print {
            /* Mengatur kertas ke mode Landscape */
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                font-size: 9px;
            }

            .print-container {
                padding: 0;
                max-width: 100%;
            }

            .report-header h3 {
                font-size: 14px;
            }

            table {
                font-size: 8px;
                box-shadow: none; /* Hilangkan shadow saat cetak */
            }

            th, td {
                padding: 4px 3px; /* Kurangi padding saat cetak */
            }

            /* Memastikan header tabel diulang di setiap halaman */
            thead {
                display: table-header-group;
            }

            /* Mencegah baris terpotong di tengah halaman */
            tbody tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="report-header">
            <h3>Rekap Kehadiran & Nilai - {{ $kelas ?? '' }}</h3>
        </div>

        <div class="report-info">
            <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 3%;">#</th>
                        <th style="width: 8%;">NIS</th>
                        <th style="width: 18%;">Nama</th>
                        <th style="width: 8%;">Kelas</th>
                        <th style="width: 6%;">Pertemuan</th>
                        <th style="width: 5%;">Hadir</th>
                        <th style="width: 5%;">Sakit</th>
                        <th style="width: 5%;">Izin</th>
                        <th style="width: 5%;">Alpa</th>
                        <th style="width: 5%;">% Hadir</th>
                        <th style="width: 6%;">Total Tugas</th>
                        <th style="width: 5%;">Cnt Tgs</th>
                        <th style="width: 5%;">Cnt Ulg</th>
                        <th style="width: 5%;">Cnt UTS</th>
                        <th style="width: 5%;">Cnt UAS</th>
                        <th style="width: 6%;">Rata-rata</th>
                        <th style="width: 6%;">Tertinggi</th>
                        <th style="width: 6%;">Terendah</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($rows as $r)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $r[0] ?? '' }}</td>
                            <td>{{ $r[1] ?? '' }}</td>
                            <td>{{ $r[2] ?? '' }}</td>
                            <td>{{ $r[3] ?? '' }}</td>
                            <td>{{ $r[4] ?? '' }}</td>
                            <td>{{ $r[5] ?? '' }}</td>
                            <td>{{ $r[6] ?? '' }}</td>
                            <td>{{ $r[7] ?? '' }}</td>
                            <td>{{ $r[8] ?? '' }}</td>
                            <td>{{ $r[9] ?? '' }}</td>
                            <td>{{ $r[10] ?? '' }}</td>
                            <td>{{ $r[11] ?? '' }}</td>
                            <td>{{ $r[12] ?? '' }}</td>
                            <td>{{ $r[13] ?? '' }}</td>
                            <td>{{ $r[14] ?? '' }}</td>
                            <td>{{ $r[15] ?? '' }}</td>
                            <td>{{ $r[16] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
