<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Agenda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP AGENDA PEMBELAJARAN</h1>
        <p>Tanggal Cetak: {{ date('d/m/Y') }}</p>
        @if($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai'))
            <p>Periode: {{ $request->tanggal_mulai }} s/d {{ $request->tanggal_selesai }}</p>
        @elseif($request->filled('tanggal'))
            <p>Tanggal: {{ $request->tanggal }}</p>
        @endif
        @if($request->filled('kelas_id'))
            <p>Kelas: {{ App\Models\Kelas::find($request->kelas_id)->nama_kelas }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Pembuat</th>
                <th>Status TTD</th>
                <th>TTD (Gambar)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($agendas as $agenda)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $agenda->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $agenda->jampel->nama_jam }}</td>
                    <td>{{ $agenda->kelas->nama_kelas }}</td>
                    <td>{{ $agenda->mata_pelajaran }}</td>
                    <td>{{ $agenda->user->name }}
                        @if ($agenda->pembuat === 'guru')
                            (Guru)
                        @else
                            (Siswa)
                        @endif
                    </td>
                    <td>
                        @if ($agenda->status_ttd)
                            Sudah
                        @else
                            Belum
                        @endif
                    </td>
                    <td>
                        @if (!empty($agenda->tanda_tangan))
                            <img src="{{ $agenda->tanda_tangan }}" style="height:50px; object-fit:contain;" />
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>
</body>
</html>