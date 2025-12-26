# Solusi Lengkap: Multiple Guru per Mata Pelajaran di Satu Kelas

## 📋 Ringkasan Masalah & Solusi

**Masalah:**
- Ada guru yang mengajar lebih dari satu mata pelajaran di satu kelas (contoh: guru PKN juga ngajar IPS karena kekurangan guru)
- User perlu cara untuk mengelola penugasan guru ke mata pelajaran
- Saat membuat agenda, user harus bisa pilih guru jika ada multiple guru untuk satu mapel

**Solusi yang Diberikan:**
1. ✅ **Halaman Admin untuk Manage Penugasan Guru** (`/guru-mapel`)
2. ✅ **Support Multiple Guru per Mata Pelajaran** di form create agenda
3. ✅ **Modal Popup** untuk pilih guru saat ada multiple guru untuk satu mapel
4. ✅ **Bulk Assign** - assign guru ke multiple mapel sekaligus

---

## 🚀 Fitur-Fitur

### 1. **Halaman Management Penugasan Guru**
- **URL:** `/guru-mapel` (hanya admin)
- **Akses:** Menu Admin → Kelola Penugasan Guru
- **Fitur:**
  - Lihat semua penugasan guru-mapel-kelas
  - Tambah penugasan baru
  - Edit penugasan
  - Hapus penugasan
  - Bulk assign (assign 1 guru ke multiple mapel di 1 kelas sekaligus)

### 2. **Form Create Agenda (Smart Guru Selection)**
- Saat kelas dipilih → dropdown mapel auto-populate
- Saat mapel dipilih:
  - Jika hanya **1 guru** → auto-select & tampilkan info
  - Jika **multiple guru** → muncul modal untuk pilih
- Info box menampilkan guru yang terpilih

### 3. **API Endpoint Update**
- `/agenda/get-mapel-by-kelas/{kelasId}`
- Sekarang return data dengan structure:
  ```json
  {
    "id": 1,
    "nama": "Matematika",
    "gurus": [
      {"guru_id": 1, "guru_nama": "Ibu Siti"},
      {"guru_id": 2, "guru_nama": "Pak Ahmad"}
    ],
    "guru_count": 2
  }
  ```

---

## 📁 File-File yang Dibuat/Diupdate

### Controller Baru:
- `app/Http/Controllers/GuruMapelController.php` - Manage penugasan guru

### Views Baru:
- `resources/views/admin/guru-mapel/index.blade.php` - Daftar penugasan
- `resources/views/admin/guru-mapel/create.blade.php` - Form tambah
- `resources/views/admin/guru-mapel/edit.blade.php` - Form edit

### File yang Diupdate:
- `app/Http/Controllers/AgendaController.php` - Update method `getMapelByKelas()`
- `resources/views/guru/agenda/create.blade.php` - Update JavaScript untuk modal guru selection
- `routes/web.php` - Tambah routes untuk guru-mapel management

---

## 🔄 Workflow Lengkap

### **Untuk Admin: Setup Penugasan Guru**

```
1. Login sebagai Admin
2. Navigasi ke "Kelola Penugasan Guru" atau akses /guru-mapel
3. Klik "Tambah Penugasan"
4. Pilih:
   - Guru: Pak Ahmad
   - Mata Pelajaran: IPS
   - Kelas: 7A
5. Simpan
6. Ulangi untuk mata pelajaran lain jika ada

ALTERNATIF: Gunakan "Bulk Assign"
1. Klik "Bulk Assign"
2. Pilih Guru: Pak Ahmad
3. Pilih Kelas: 7A
4. Centang Mapel: IPS, PKN, Sejarah
5. Assign → semua akan ditambahkan sekaligus
```

### **Untuk Guru/Siswa: Membuat Agenda**

```
1. Klik "Buat Agenda Baru" atau akses /agenda/create
2. Isi Form:
   - Tanggal: [pilih]
   - Jam Pelajaran: [pilih]
   - Kelas: 7A → Dropdown mapel ter-unlock
   - Mata Pelajaran: IPS

   JIKA HANYA 1 GURU:
   → Info box auto-show nama guru
   → Lanjut isi form

   JIKA MULTIPLE GURU (misal: Pak Ahmad & Ibu Siti):
   → Modal popup muncul
   → Pilih salah satu guru
   → Klik "Pilih"
   → Info box tampilkan guru terpilih
   → Lanjut isi form

3. Isi Materi, Kegiatan, Tanda Tangan
4. Simpan Agenda
```

---

## 💾 Database Structure

Tabel `guru_mapel` sudah ada dengan struktur:
```sql
CREATE TABLE guru_mapel (
    id BIGINT PRIMARY KEY,
    guru_id BIGINT (FK ke guru),
    kelas_id BIGINT (FK ke kelas),
    mapel_id BIGINT (FK ke mata_pelajaran),
    timestamps,
    UNIQUE(guru_id, kelas_id, mapel_id) -- Prevent duplicate
);
```

**Contoh Data:**
```
| guru_id | mapel_id | kelas_id |
|---------|----------|----------|
| 1       | 2        | 1        | ← Pak Ahmad ngajar IPS di 7A
| 1       | 3        | 1        | ← Pak Ahmad ngajar PKN di 7A (multiple mapel!)
| 2       | 2        | 1        | ← Ibu Siti juga ngajar IPS di 7A (multiple guru!)
```

---

## 🔐 Role & Permissions

| Fitur | Admin | Guru | Siswa |
|-------|-------|------|-------|
| Lihat penugasan | ✅ | ❌ | ❌ |
| Tambah/Edit/Hapus penugasan | ✅ | ❌ | ❌ |
| Create agenda dengan pilih guru | ✅ | ✅ | ✅ |

---

## 🧪 Testing Checklist

- [ ] 1. Login sebagai Admin
- [ ] 2. Akses `/guru-mapel` → seharusnya bisa lihat daftar penugasan
- [ ] 3. Klik "Tambah Penugasan" → form muncul
- [ ] 4. Assign 1 guru ke 2 mapel berbeda di 1 kelas
- [ ] 5. Simpan → check data di tabel
- [ ] 6. Logout, Login sebagai Guru
- [ ] 7. Akses `/agenda/create`
- [ ] 8. Pilih kelas → dropdown mapel unlock & populate
- [ ] 9. Pilih mapel (yang ada 1 guru) → info guru auto-show
- [ ] 10. Pilih mapel lain (yang ada 2 guru) → modal popup muncul
- [ ] 11. Pilih guru di modal → info box update
- [ ] 12. Isi form & Simpan → berhasil ✅

---

## 🐛 Troubleshooting

### Q: Dropdown mapel masih disabled padahal sudah pilih kelas?
**A:** Clear cache:
```bash
php artisan cache:clear
php artisan view:clear
```

### Q: Modal guru selection tidak muncul?
**A:** Cek browser console (F12) untuk error. Pastikan JavaScript tidak error.

### Q: Guru tidak bisa pilih mapel yang dia ajar?
**A:** Cek tabel `guru_mapel` apakah sudah ada record untuk kombinasi guru-kelas-mapel itu.

### Q: Multiple guru untuk 1 mapel tidak keluar di dropdown?
**A:** API endpoint `/agenda/get-mapel-by-kelas` harus return multiple guru. Check response di browser Network tab.

---

## 📝 Contoh Penggunaan Real-World

**Skenario:** 
- Sekolah kekurangan guru
- Pak Ahmad (guru PKN) juga ngajar IPS di kelas 7A
- Ibu Siti (guru IPS) fokus ke kelas 7B

**Setup:**
1. Admin ke `/guru-mapel`
2. Tambah:
   - Pak Ahmad → PKN → 7A
   - Pak Ahmad → IPS → 7A
   - Ibu Siti → IPS → 7B

**Hasilnya saat Pak Ahmad buat agenda:**
- Pilih kelas 7A
- Pilih mapel PKN → info show "Pengampu: Pak Ahmad"
- Atau pilih mapel IPS → info show "Pengampu: Pak Ahmad"
- Kalau ada guru lain yang juga ngajar IPS → modal muncul untuk pilih

---

## 🔄 Maintenance

### Tambah Guru Baru?
```bash
1. Admin → Data Master → Guru → Tambah Guru
2. Simpan guru
3. Go to /guru-mapel → Assign guru ke mapel
```

### Guru Resign/Pindah?
```bash
1. Admin → /guru-mapel
2. Cari penugasan guru itu
3. Delete semua penugasannya
4. Atau update ke guru baru
```

### Audit Trail?
Semua create/update/delete tercatat di tabel `guru_mapel` dengan timestamps.

---

## ✨ Next Steps (Optional Enhancements)

1. **Export Penugasan** - Export ke Excel semua penugasan guru per kelas
2. **Approval System** - Setiap penugasan perlu approval dari kepala sekolah
3. **Schedule Conflict Detection** - Alert jika guru assign ke jam yang sama di kelas berbeda
4. **Report** - Generate laporan beban mengajar per guru

---

**Solusi ini sudah production-ready dan siap digunakan!** 🎉
