# 🎯 Quick Reference: Walikelas Absensi Access

## Sebelum & Sesudah

### SEBELUM (❌ Walikelas tidak bisa input absensi)
```
┌─────────────────────────┐
│   Absensi Controller    │
└─────────────────────────┘
         ↓
   hasRole('guru') ✅ 
   hasRole('walikelas') ❌  ← DITOLAK
```

### SESUDAH (✅ Walikelas bisa input absensi)
```
┌─────────────────────────┐
│   Absensi Controller    │
└─────────────────────────┘
         ↓
   hasRole(['guru', 'walikelas']) ✅ 
        ↓
   getGuruFromUser()
        ↓
   check GuruMapel
        ↓
   ✅ DITERIMA
```

---

## Workflow: Input Absensi

```
┌────────────────────────────────────────┐
│  1. Walikelas Login                    │
│     role = 'walikelas'                 │
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  2. Buka Halaman Input Absensi         │
│     GET /absensi                       │
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  3. Sistem Cek Permission              │
│     canManageAbsensi() → true ✅       │
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  4. Ambil Data Guru dari User          │
│     $guru = getGuruFromUser()          │
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  5. Tampilkan Kelas yang Diampu        │
│     GuruMapel::where('guru_id', ...)   │
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  6. User Pilih Kelas & Mata Pelajaran  │
│     Tunggu input siswa status absensi  │
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  7. Submit Form                        │
│     POST /absensi                      │
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  8. Validasi & Simpan Data             │
│     - Cek role & ownership             │
│     - Cek kombinasi kelas-mapel-guru   │
│     - INSERT ke absensi & detail_absensi
└────────────────────────────────────────┘
              ↓
┌────────────────────────────────────────┐
│  9. Success ✅                         │
│     "Data absensi berhasil disimpan!"  │
└────────────────────────────────────────┘
```

---

## Helper Methods Reference

### ✅ canManageAbsensi()
**Fungsi**: Cek apakah user bisa manage absensi
```php
if (!$this->canManageAbsensi()) {
    return redirect()->back()->with('error', 'Akses ditolak');
}
// Menerima: guru, walikelas
// Menolak: siswa, admin, dll
```

### ✅ getGuruFromUser()
**Fungsi**: Ambil data guru dari user yang login
```php
$guru = $this->getGuruFromUser();
if (!$guru) {
    return redirect()->back()->with('error', 'Data guru tidak ditemukan');
}
// Gunakan $guru->id untuk query ke GuruMapel
```

### ✅ teachesClass()
**Fungsi**: Cek apakah guru mengajar kelas tertentu
```php
$teaches = $this->teachesClass($guru->id, $kelas_id, $mapel_id);
if (!$teaches) {
    return back()->with('error', 'Anda tidak mengajar kelas ini');
}
```

### ✅ getAccessibleClasses()
**Fungsi**: Ambil semua kelas yang bisa diakses guru
```php
$classes = $this->getAccessibleClasses();
// Return: Collection of Kelas model
```

### ✅ getAccessibleMapelByKelas()
**Fungsi**: Ambil semua mapel di kelas tertentu yang diampu guru
```php
$mapels = $this->getAccessibleMapelByKelas($kelas_id);
// Return: Collection of MataPelajaran model
```

---

## Query Database Reference

### Cek Walikelas & Guru Mapel
```sql
-- Lihat semua guru (termasuk walikelas)
SELECT u.id, u.name, u.role, g.id as guru_id
FROM users u
LEFT JOIN guru g ON u.id = g.users_id
WHERE u.role IN ('guru', 'walikelas');

-- Lihat kelas yang diampu oleh walikelas (guru_id: 5)
SELECT g.id, g.nama_guru, km.kelas_id, k.nama_kelas, m.nama
FROM guru g
JOIN guru_mapel km ON g.id = km.guru_id
JOIN kelas k ON km.kelas_id = k.id
JOIN mata_pelajaran m ON km.mapel_id = m.id
WHERE g.id = 5;

-- Lihat absensi yang dibuat oleh walikelas
SELECT a.id, a.tanggal, k.nama_kelas, m.nama, a.jam
FROM absensi a
JOIN guru g ON a.guru_id = g.id
JOIN kelas k ON a.kelas_id = k.id
JOIN mata_pelajaran m ON a.mapel_id = m.id
WHERE g.users_id = 5;  -- walikelas user_id
```

---

## Permission Matrix

| Action | Guru | Walikelas | Siswa | Admin |
|--------|------|-----------|-------|-------|
| Input Absensi | ✅ | ✅ | ❌ | ❌ |
| Lihat Absensi Milik Sendiri | ✅ | ✅ | ✅ | ✅ |
| Edit Absensi Milik Sendiri | ✅ | ✅ | ❌ | ✅ |
| Lihat Semua Absensi | ❌ | ❌ | ❌ | ✅ |
| Edit Semua Absensi | ❌ | ❌ | ❌ | ✅ |

---

## Common Issues & Solutions

### ❌ "Data guru tidak ditemukan"
**Penyebab**: User walikelas tidak punya record di tabel `guru`
**Solusi**:
```sql
-- Pastikan walikelas ada di tabel guru
INSERT INTO guru (users_id, nama_guru, nip)
VALUES (5, 'Nama Walikelas', '123456789');
```

### ❌ "Anda tidak memiliki akses ke kelas ini"
**Penyebab**: Guru/Walikelas tidak punya mapping di `guru_mapel`
**Solusi**:
```sql
-- Tambahkan mapping kelas untuk walikelas
INSERT INTO guru_mapel (guru_id, kelas_id, mapel_id)
VALUES (5, 1, 3);  -- guru_id=5, kelas_id=1, mapel_id=3
```

### ❌ "Kombinasi kelas, mapel, dan guru tidak valid"
**Penyebab**: Kelas dan mapel belum di-set untuk guru/walikelas
**Solusi**: Gunakan query di atas untuk menambahkan ke `guru_mapel`

---

## Testing Scenarios

### ✅ Scenario 1: Walikelas Input Absensi (HARUS BERHASIL)
```
1. Login: email=walikelas@sekolah.com, role='walikelas'
2. Buka: /absensi
3. Pilih Kelas: X IPA 1
4. Pilih Mapel: Matematika
5. Input status siswa
6. Klik "Simpan"
7. Verifikasi: Absensi tersimpan di DB ✅
```

### ✅ Scenario 2: Walikelas Tidak Bisa Access Kelas Lain (HARUS DITOLAK)
```
1. Login: email=walikelas@sekolah.com, role='walikelas'
2. URL: /absensi?kelas_id=99 (kelas yang tidak diampu)
3. Verifikasi: Ditampilkan error "Tidak punya akses" ✅
```

### ✅ Scenario 3: Guru Masih Bisa Input Absensi (HARUS BERHASIL)
```
1. Login: email=guru@sekolah.com, role='guru'
2. Input absensi seperti biasa
3. Verifikasi: Masih berfungsi normal ✅
```

---

## Migration Notes

Jika mengupdate dari versi sebelumnya:

✅ **Tidak perlu migration database** - struktur table tetap sama  
✅ **Hanya update code** - controller dan trait  
✅ **Pastikan guru_mapel terisi** - untuk walikelas yang ingin input absensi  

```bash
# Langkah update:
1. Update AgendaController.php
2. Update AbsensiController.php
3. Tambah CanManageAbsensi.php trait
4. Jalankan aplikasi
5. Test dengan walikelas account
```

---

**Last Updated**: 19 December 2025  
**Status**: ✅ Complete & Ready to Use
