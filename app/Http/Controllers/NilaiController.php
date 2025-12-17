<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        $nilai = Nilai::where('guru_id', $user_id)
            ->with(['siswa', 'mapel', 'kelas'])
            ->latest()
            ->get();

        return view('nilai.index', compact('nilai'));
    }

    public function create()
    {
        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        // Ambil kelas dan mapel yang diajar oleh guru ini
        $kelas = Kelas::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $mapel = MataPelajaran::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $jenisNilai = ['tugas', 'ulangan', 'uts', 'uas'];

        return view('nilai.create', compact('kelas', 'mapel', 'jenisNilai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jenis' => 'required|string|max:50',
            'nilai' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        // Simpan nilai untuk siswa
        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'guru_id' => $user_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'jenis' => $request->jenis,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data nilai berhasil disimpan!'
        ]);
    }

    public function show($id)
    {
        $nilai = Nilai::with(['siswa', 'guru', 'mapel', 'kelas'])->findOrFail($id);
        return view('nilai.show', compact('nilai'));
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);

        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        // Ambil kelas dan mapel yang diajar oleh guru ini
        $kelas = Kelas::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $mapel = MataPelajaran::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $jenisNilai = ['tugas', 'ulangan', 'uts', 'uas'];

        return view('nilai.edit', compact('nilai', 'kelas', 'mapel', 'jenisNilai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jenis' => 'required|in:tugas,ulangan,uts,uas',
            'nilai' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'jenis' => $request->jenis,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil dihapus!');
    }
}
