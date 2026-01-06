<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Agenda</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15mm;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .header h1 {
            margin: 0 0 10px 0;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            flex-shrink: 0;
        }

        .info-value {
            flex-grow: 1;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th {
            background-color: #4a5568;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px 8px;
            border: 1px solid #2d3748;
            font-size: 11px;
            white-space: nowrap;
        }

        td {
            padding: 8px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f7fafc;
        }

        tr:hover {
            background-color: #edf2f7;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .status-sudah {
            color: #38a169;
            font-weight: bold;
        }

        .status-belum {
            color: #e53e3e;
            font-weight: bold;
        }

        .ttd-img {
            max-height: 40px;
            object-fit: contain;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #666;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            body {
                font-size: 10px;
            }

            .container {
                padding: 0;
                max-width: 100%;
            }

            .header h1 {
                font-size: 16px;
            }

            .info-section {
                background-color: transparent;
                padding: 5px 0;
            }

            table {
                font-size: 9px;
                box-shadow: none;
            }

            th, td {
                padding: 5px;
            }

            .ttd-img {
                max-height: 30px;
            }

            .footer {
                position: fixed;
                bottom: 10mm;
                right: 10mm;
                margin-top: 0;
            }

            tr {
                page-break-inside: avoid;
            }

            thead {
                display: table-header-group;
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header h1 {
                font-size: 16px;
            }

            table {
                font-size: 10px;
            }

            th, td {
                padding: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Rekap Agenda Pembelajaran</h1>
        </div>

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Tanggal Cetak:</span>
                <span class="info-value">{{ date('d/m/Y') }}</span>
            </div>
            @if($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai'))
                <div class="info-row">
                    <span class="info-label">Periode:</span>
                    <span class="info-value">{{ $request->tanggal_mulai }} s/d {{ $request->tanggal_selesai }}</span>
                </div>
            @elseif($request->filled('tanggal'))
                <div class="info-row">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ $request->tanggal }}</span>
                </div>
            @endif
            @if($request->filled('kelas_id'))
                <div class="info-row">
                    <span class="info-label">Kelas:</span>
                    <span class="info-value">{{ App\Models\Kelas::find($request->kelas_id)->nama_kelas }}</span>
                </div>
            @endif
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 10%;">Tanggal</th>
                        <th style="width: 15%;">Jam</th>
                        <th style="width: 15%;">Kelas</th>
                        <th style="width: 20%;">Mata Pelajaran</th>
                        <th style="width: 15%;">Pembuat</th>
                        <th style="width: 10%;">Status TTD</th>
                        <th style="width: 10%;">TTD</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($agendas as $agenda)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">{{ $agenda->tanggal->format('d/m/Y') }}</td>
                            <td class="text-center">{{ $agenda->startJampel?->nama_jam ?? '-' }} s/d {{ $agenda->endJampel?->nama_jam ?? '-' }}</td>
                            <td>{{ $agenda->kelas->nama_kelas }}</td>
                            <td>{{ $agenda->mata_pelajaran }}</td>
                            <td>
                                {{ $agenda->user->name }}
                                <small class="text-muted">
                                    ({{ $agenda->pembuat === 'guru' ? 'Guru' : 'Siswa' }})
                                </small>
                            </td>
                            <td class="text-center">
                                @if ($agenda->status_ttd)
                                    <span class="status-sudah">Sudah</span>
                                @else
                                    <span class="status-belum">Belum</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (!empty($agenda->tanda_tangan))
                                    <img src="{{ $agenda->tanda_tangan }}" class="ttd-img" alt="Tanda Tangan" />
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Dicetak oleh: {{ auth()->user()->name }}</p>
            <p>{{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
