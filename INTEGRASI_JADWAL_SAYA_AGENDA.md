# Integrasi Jadwal-Saya ke Create Agenda

## Apa yang Dikerjakan

Telah diimplementasikan integrasi lengkap antara halaman **Jadwal Saya** dan halaman **Buat Agenda** sehingga guru dapat langsung membuat agenda dari jadwal yang sudah ditetapkan admin.

## Fitur Utama

### 1. **Auto-Populate Form Agenda**
Ketika guru mengklik tombol "Buat Agenda" dari halaman Jadwal Saya, form akan otomatis terisi dengan:
- ✅ **Tanggal**: Diisi dengan hari ini
- ✅ **Jam Mulai**: Dari jadwal admin
- ✅ **Jam Selesai**: Dari jadwal admin  
- ✅ **Kelas**: Dari jadwal admin (disabled/terkunci)
- ✅ **Mata Pelajaran**: Dari jadwal admin (disabled/terkunci)
- ✅ **Guru**: Dari jadwal admin (disabled/terkunci)
- ✅ **Info Banner**: Menampilkan info yang sudah terisi

### 2. **Validasi Form yang Lebih Baik**
- Validasi semua field sebelum submit
- Tampilan error yang lebih user-friendly (notification di kanan atas)
- Validasi tanda tangan untuk guru
- Validasi materi dan kegiatan

### 3. **Smart Jam Pelajaran Selection**
- End jam pelajaran otomatis di-filter berdasarkan start jam
- Hanya menampilkan jam selesai yang >= jam mulai
- Hanya jam di hari yang sama yang ditampilkan
- Auto-select first available end jam

## Perubahan File

### A. `resources/views/guru/jadwal-saya.blade.php`
```javascript
// Sebelum:
<a href="{{ route('agenda.index') }}" ...>Buat Agenda</a>

// Sesudah:
<a href="{{ route('agenda.create') }}?schedule_id=${schedule.id}" ...>Buat Agenda</a>
```

### B. `routes/web.php`
Menambahkan route baru untuk API endpoint:
```php
Route::get('/api/schedule-for-agenda/{scheduleId}', [AgendaController::class, 'getScheduleForAgenda']);
```

### C. `app/Http/Controllers/AgendaController.php`
Menambahkan method baru:
```php
public function getScheduleForAgenda($scheduleId) {
    // Fetch schedule detail dari GuruMapel
    // Return sebagai JSON dengan success flag
}
```

### D. `resources/views/guru/agenda/create.blade.php`
Perbaikan JavaScript:
1. **Consolidate 2 DOMContentLoaded** menjadi 1
2. **Definisikan `updateEndOptions()`** di awal
3. **Tambahkan `showErrorAlert()`** untuk user-friendly error
4. **Improve form validation** dengan validasi semua field
5. **Auto-populate dari schedule** dengan proper timing/delays
6. **Event listener** untuk startJampelSelect change

## Alur Kerja

### Flow 1: Click "Buat Agenda" dari Jadwal Saya
```
1. User klik "Buat Agenda" di Jadwal Saya
   ↓
2. URL: /agenda/create?schedule_id=5
   ↓
3. Page load, detect schedule_id di URL
   ↓
4. Fetch /api/schedule-for-agenda/5
   ↓
5. Populate form dengan data dari jadwal
   ↓
6. User isi materi, kegiatan, tanda tangan
   ↓
7. User submit form
```

### Flow 2: Form Validation & Submit
```
1. User klik Submit
   ↓
2. JavaScript validate semua field
   ↓
3. Jika error → Show red error banner
   ↓
4. Jika OK → Submit form ke /agenda (POST)
   ↓
5. Server validate & simpan
   ↓
6. Redirect ke /agenda dengan success message
```

## Testing

### Test Case 1: Populate dari Jadwal
```
1. Buka Jadwal Saya
2. Klik "Buat Agenda" 
3. Verify: Kelas, Mapel, Jam Mulai, Jam Selesai sudah terisi
4. Verify: Field tersebut di-disable (tidak bisa diubah)
5. Verify: Info banner menampilkan data yang dimuat
```

### Test Case 2: Form Validation
```
1. Buka agenda/create (tanpa schedule_id)
2. Kosongkan Jam Mulai
3. Klik Submit
4. Verify: Error notification muncul "Jam Mulai harus diisi!"
5. Isi Jam Mulai
6. Verify: Jam Selesai otomatis ter-filter
```

### Test Case 3: Save Agenda
```
1. Populate dari jadwal
2. Isi Materi Pembelajaran
3. Isi Kegiatan/Aktivitas
4. (Untuk guru) Gambar Tanda Tangan
5. Klik Simpan
6. Verify: Redirect ke /agenda dengan success message
```

## Browser Console Logs

Untuk debugging, console log menampilkan:
```javascript
"Schedule ID detected: 5"
"Schedule data fetched: {kelas_id: 1, mapel_id: 2, ...}"
"Setting kelas to: 1"
"Step 3: Setting mapel to: 2"
"Step 3b: Setting jam mulai to: 3"
"Step 5: Setting jam selesai to: 5"
"End options updated"
"Form submitted, checking all validations..."
"All validations passed, form will be submitted"
```

## Troubleshooting

### Issue: Form reload tanpa error/success
**Solusi**: 
- Check browser console untuk errors
- Check Laravel logs: `storage/logs/laravel.log`
- Pastikan semua field required sudah terisi
- Pastikan signature sudah digambar (untuk guru)

### Issue: Data tidak populate
**Solusi**:
- Pastikan schedule_id ada di URL: `/agenda/create?schedule_id=5`
- Check network tab → `/api/schedule-for-agenda/5` → verify response
- Verify guru tersebut punya akses ke schedule itu

### Issue: Jam Selesai tidak ter-filter
**Solusi**:
- Check console untuk errors di `updateEndOptions()`
- Pastikan start jam pelajaran sudah dipilih
- Refresh halaman

## Notes

- ✅ Data dari schedule di-lock (disabled) agar guru tidak bisa mengubahnya
- ✅ Hanya materi, kegiatan, catatan, dan tanda tangan yang bisa diubah guru
- ✅ Validation error ditampilkan dengan user-friendly notification
- ✅ Form tidak akan submit jika ada field yang kosong
- ✅ Auto-consolidation ketika agenda sudah tersimpan & ditanda-tangani

