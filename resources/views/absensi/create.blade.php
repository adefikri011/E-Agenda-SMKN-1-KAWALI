@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Absensi Siswa</h4>
                </div>
                <div class="card-body">
                    <!-- Informasi Absensi -->
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <div class="flex-grow-1">
                            <h5 class="alert-heading">Sedang Berlangsung</h5>
                            <p class="mb-1"><strong>{{ $mapel->nama_mapel }}</strong></p>
                            <p class="mb-1">Kelas {{ $kelas->nama_kelas }}</p>
                            <p class="mb-1">Jam {{ $jam }}</p>
                            <p class="mb-0">Pertemuan ke-{{ $pertemuan }}</p>
                        </div>
                    </div>

                    <!-- Form Absensi -->
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                        <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                        <input type="hidden" name="jam" value="{{ $jam }}">
                        <input type="hidden" name="pertemuan" value="{{ $pertemuan }}">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswa as $index => $s)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $s->nis }}</td>
                                            <td>{{ $s->nama_siswa }}</td>
                                            <td>
                                                <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $s->id }}">
                                                <select name="absensi[{{ $index }}][status]" class="form-select">
                                                    <option value="hadir">Hadir</option>
                                                    <option value="izin">Izin</option>
                                                    <option value="sakit">Sakit</option>
                                                    <option value="alpha">Alpha</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">Simpan Absensi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
