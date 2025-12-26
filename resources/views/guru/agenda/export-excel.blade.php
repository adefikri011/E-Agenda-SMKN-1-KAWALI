<table>
    <thead>
        <tr>
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
        @foreach($agendas as $agenda)
            <tr>
                <td>{{ $agenda->tanggal->format('d/m/Y') }}</td>
                <td>{{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} s/d {{ $agenda->endJampel?->nama_jam ?? '-' }}</td>
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
