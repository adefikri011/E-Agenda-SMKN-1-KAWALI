<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap {{ $kelas ?? '' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #333; padding:6px; text-align:left }
        th { background:#eee }
    </style>
</head>
<body>
    <h3>Rekap Kehadiran & Nilai - {{ $kelas ?? '' }}</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Pertemuan</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>
                <th>% Hadir</th>
                <th>Total Tugas</th>
                <th>Rata-rata</th>
                <th>Tertinggi</th>
                <th>Terendah</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rows as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
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
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
