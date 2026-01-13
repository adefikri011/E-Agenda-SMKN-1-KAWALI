<?php

namespace App\Http\Controllers\data;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\GuruMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MapelImport;
use App\Exports\MapelTemplateExport;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = MataPelajaran::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('kode', 'like', '%' . $search . '%')
                  ->orWhere('tingkat', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan tingkat
        if ($request->has('tingkat') && $request->tingkat != '') {
            $query->where('tingkat', $request->tingkat);
        }

        $mapel = $query->paginate(10);

        // Mendapatkan daftar tingkat untuk filter
        $tingkatList = MataPelajaran::distinct()->pluck('tingkat')->filter();

        return view('admin.data.mapel.index', compact('mapel', 'tingkatList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.data.mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_pelajaran,kode',
            'tingkat' => 'nullable|string|in:X,XI,XII',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        MataPelajaran::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'tingkat' => $request->tingkat,
        ]);

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mapel = MataPelajaran::with(['gurus', 'kelas', 'agendas'])->findOrFail($id);

        return view('admin.data.mapel.show', compact('mapel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        return view('admin.data.mapel.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_pelajaran,kode,' . $id,
            'tingkat' => 'nullable|string|in:X,XI,XII',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mapel->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'tingkat' => $request->tingkat,
        ]);

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        // Cek apakah mata pelajaran sudah digunakan di GuruMapel
        if ($mapel->guruMapel()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena sudah digunakan dalam penugasan guru');
        }

        // Cek apakah mata pelajaran sudah digunakan di Agenda
        if ($mapel->agendas()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena sudah digunakan dalam agenda');
        }

        $mapel->delete();

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus');
    }

    /**
     * Import data mata pelajaran dari Excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Excel::import(new MapelImport, $request->file('file'));

            return redirect()->route('mapel.index')
                ->with('success', 'Data mata pelajaran berhasil diimpor');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Download template import Excel
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadTemplate()
    {
        return Excel::download(new MapelTemplateExport, 'template_import_mapel.xlsx');
    }

    /**
     * Assign guru to mata pelajaran
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignGuru(Request $request, $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'guru_id' => 'required|array',
            'guru_id.*' => 'exists:gurus,id',
            'kelas_id' => 'required|array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Hapus penugasan lama
        GuruMapel::where('mapel_id', $id)->delete();

        // Tambah penugasan baru
        foreach ($request->guru_id as $index => $guruId) {
            if (isset($request->kelas_id[$index])) {
                GuruMapel::create([
                    'mapel_id' => $id,
                    'guru_id' => $guruId,
                    'kelas_id' => $request->kelas_id[$index],
                ]);
            }
        }

        return redirect()->route('mapel.show', $id)
            ->with('success', 'Penugasan guru berhasil diperbarui');
    }
}
