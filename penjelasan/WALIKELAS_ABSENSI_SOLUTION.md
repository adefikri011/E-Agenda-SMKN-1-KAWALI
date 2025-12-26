# Solusi: Walikelas Dapat Input Absensi

## 📋 Masalah
Sebelumnya, hanya **guru** yang dapat menginput data absensi, sedangkan **walikelas** juga seharusnya memiliki akses yang sama karena walikelas juga berfungsi sebagai guru.

## ✅ Solusi

### 1. **Membuat Trait Helper: `CanManageAbsensi`**
File: `app/Traits/CanManageAbsensi.php`

Trait ini menyediakan helper methods untuk mengecek dan mengelola akses input absensi:
- `canManageAbsensi()` - Cek apakah user bisa manage absensi (guru atau walikelas)
- `getGuruFromUser()` - Mendapatkan data guru dari user yang login
- `teachesClass()` - Cek apakah guru mengajar di kelas tertentu
- `getAccessibleClasses()` - Dapatkan kelas yang bisa diakses
- `getAccessibleMapelByKelas()` - Dapatkan mapel di kelas tertentu

### 2. **Update AbsensiController**

Ditambahkan trait `CanManageAbsensi` dan updated semua methods untuk support walikelas:

**Methods yang di-update:**
- `index()` - Add permission check untuk guru dan walikelas
- `getSiswaByKelas()` - Add access control
- `create()` - Add permission check
- `store()` - Add permission check dan gunakan helper function
- `show()` - Add ownership verification
- `update()` - Add permission check dan ownership verification

**Key Changes:**
```php
// Sebelum (hanya guru)
if (!auth()->user()->hasRole('guru')) { }

// Sesudah (guru atau walikelas)
if (!auth()->user()->hasRole(['guru', 'walikelas'])) { }

// Sebelum (akses langsung ke guru)
GuruMapel::where('guru_id', auth()->user()->guru->id)

// Sesudah (gunakan helper)
$guru = $this->getGuruFromUser();
GuruMapel::where('guru_id', $guru->id)
```

### 3. **Update AgendaController**

Ditambahkan trait `CanManageAbsensi` dan updated semua methods untuk consistency:

**Methods yang di-update:**
- `getGuruKelas()` - Support walikelas
- `getGuruMapel()` - Support walikelas
- `index()` - Support walikelas
- `store()` - Support walikelas
- `show()`, `edit()`, `update()`, `destroy()` - Support walikelas
- `signForm()`, `sign()` - Support walikelas
- `rekap()`, `exportPdf()`, `exportExcel()` - Support walikelas
- `getSiswaTidakHadir()` - Support walikelas

## 🔄 Bagaimana Cara Kerjanya

### Alur Akses Absensi
```
1. User Login dengan role = 'walikelas' atau 'guru'
                    ↓
2. AbsensiController::index() menerima request
                    ↓
3. Cek: auth()->user()->hasRole(['guru', 'walikelas']) ✅
                    ↓
4. Ambil data guru: $guru = $this->getGuruFromUser()
                    ↓
5. Ambil kelas yang diampu dari guru_mapel table
                    ↓
6. Tampilkan form input absensi untuk kelas yang diampu
                    ↓
7. Simpan data absensi dengan guru_id dari $guru->id
```

### Proteksi & Validasi
- **Cek Role**: Hanya guru dan walikelas yang bisa akses
- **Cek Ownership**: Guru/walikelas hanya bisa lihat dan edit data milik mereka
- **Cek Kelas**: Guru/walikelas hanya bisa input absensi untuk kelas yang mereka ampu
- **Data Validation**: Kombinasi kelas, mapel, dan guru harus valid di GuruMapel table

## 📝 Contoh Implementasi Database

Pastikan `guru_mapel` table sudah terisi dengan data walikelas:

```sql
-- Contoh: Walikelas untuk Kelas X (sebagai guru mata pelajaran)
INSERT INTO guru_mapel (guru_id, kelas_id, mapel_id)
VALUES (
    (SELECT id FROM guru WHERE users_id = 5), -- walikelas user ID 5
    1,  -- Kelas X
    1   -- Mata Pelajaran yang diampu
);
```

## ✨ Benefits

✅ Walikelas dapat input absensi seperti guru biasa  
✅ Data tetap aman - ownership-based access control  
✅ Mudah di-maintain dengan centralized helper methods  
✅ Konsisten di semua controller (Absensi & Agenda)  
✅ Dapat di-extend untuk role lain di masa depan  

## 🧪 Testing Checklist

- [ ] Login sebagai walikelas
- [ ] Akses halaman input absensi
- [ ] Pilih kelas yang diampu
- [ ] Pilih mata pelajaran
- [ ] Simpan data absensi
- [ ] Verifikasi data tersimpan di database
- [ ] Edit data absensi yang sudah dibuat
- [ ] Lihat history absensi di rekap

## 📚 Files Yang Di-Update

1. `app/Traits/CanManageAbsensi.php` - Helper trait (NEW)
2. `app/Http/Controllers/AbsensiController.php` - Updated untuk support walikelas
3. `app/Http/Controllers/AgendaController.php` - Updated untuk consistency
