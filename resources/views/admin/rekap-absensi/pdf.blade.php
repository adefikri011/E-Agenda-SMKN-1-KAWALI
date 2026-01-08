<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            padding: 20px;
            max-width: 210mm;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .filter-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .filter-info p {
            margin: 3px 0;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background-color: #1a1a1a;
            color: white;
            padding: 12px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .stat-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            font-size: 11px;
        }
        
        .stat-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 5px 0;
        }
        
        .stat-card .label {
            color: #666;
            font-size: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }
        
        table thead {
            background-color: #e8e8e8;
        }
        
        table th {
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .empty-message {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .container {
                padding: 0;
                max-width: 100%;
            }
            
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>REKAP ABSENSI SISWA</h1>
            <p>Laporan Kehadiran Siswa</p>
        </div>
        
        <!-- Filter Info -->
        <div class="filter-info">
            <p><strong>Periode:</strong> 
                @if($tanggal)
                    {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}
                @else
                    Bulan {{ \Carbon\Carbon::parse($bulan)->format('F Y') }}
                @endif
            </p>
            @if($kelas)
                <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }}</p>
            @endif
            <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>
        </div>
        
        <!-- Data Sections -->
        @if(!empty($statistik))
            @foreach($statistik as $kelasId => $stats)
                <div class="section">
                    <div class="section-title">{{ $stats['kelas_nama'] }} - Statistik Kehadiran</div>
                    
                    <!-- Stats Grid -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="label">Total Siswa</div>
                            <div class="value">{{ $stats['total_siswa_unik'] }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="label">Hadir</div>
                            <div class="value">{{ $stats['hadir'] }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="label">Tidak Hadir</div>
                            <div class="value">{{ $stats['tidak_hadir'] }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="label">Izin</div>
                            <div class="value">{{ $stats['izin'] }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="label">Sakit</div>
                            <div class="value">{{ $stats['sakit'] }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="label">Alpha</div>
                            <div class="value">{{ $stats['alpha'] }}</div>
                        </div>
                    </div>
                    
                    <!-- Siswa Tidak Hadir -->
                    @if(count($stats['siswa_tidak_hadir']) > 0)
                        <div style="margin-top: 15px;">
                            <h3 style="font-size: 12px; margin-bottom: 10px; font-weight: bold;">Daftar Siswa Tidak Hadir</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 35%;">Nama Siswa</th>
                                        <th style="width: 20%;">NIS</th>
                                        <th style="width: 13%;">Izin</th>
                                        <th style="width: 13%;">Sakit</th>
                                        <th style="width: 14%;">Alpha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['siswa_tidak_hadir'] as $index => $siswaTidakHadir)
                                        <tr>
                                            <td style="text-align: center;">{{ $index + 1 }}</td>
                                            <td>{{ $siswaTidakHadir['nama'] }}</td>
                                            <td style="text-align: center; font-family: monospace;">{{ $siswaTidakHadir['nis'] }}</td>
                                            <td style="text-align: center;">{{ $siswaTidakHadir['izin'] > 0 ? $siswaTidakHadir['izin'] . 'x' : '-' }}</td>
                                            <td style="text-align: center;">{{ $siswaTidakHadir['sakit'] > 0 ? $siswaTidakHadir['sakit'] . 'x' : '-' }}</td>
                                            <td style="text-align: center;">{{ $siswaTidakHadir['alpha'] > 0 ? $siswaTidakHadir['alpha'] . 'x' : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-message">✓ Semua siswa hadir</div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="empty-message">Tidak ada data untuk periode yang dipilih</div>
        @endif
        
        <!-- Footer -->
        <div style="margin-top: 40px; text-align: center; font-size: 11px; color: #666; border-top: 1px solid #ddd; padding-top: 10px;">
            <p>Dokumen ini dihasilkan secara otomatis oleh sistem E-Agenda</p>
        </div>
    </div>
</body>
</html>
