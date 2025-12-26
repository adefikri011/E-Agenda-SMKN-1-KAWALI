# ✅ Verification Checklist: Walikelas Absensi Access

## 📋 Pre-Implementation Checklist

Pastikan semua ini sudah ada sebelum testing:

### Database Setup
- [ ] Tabel `users` ada (dengan role: admin, guru, walikelas, siswa)
- [ ] Tabel `guru` ada (linked ke users via users_id)
- [ ] Tabel `guru_mapel` ada (linking guru → kelas → mapel)
- [ ] Tabel `absensi` ada
- [ ] Tabel `detail_absensi` ada
- [ ] Tabel `kelas` ada
- [ ] Tabel `mata_pelajaran` ada
- [ ] Tabel `jam_pelajaran` ada

### Test Data Setup
```sql
-- 1. Buat user walikelas
INSERT INTO users (id, name, email, password, role) 
VALUES (5, 'Ibu Fatimah', 'fatimah@sekolah.com', bcrypt('password'), 'walikelas');

-- 2. Link ke tabel guru
INSERT INTO guru (users_id, nama_guru, nip) 
VALUES (5, 'Ibu Fatimah', '123456789');

-- 3. Buat mapping kelas untuk walikelas
INSERT INTO guru_mapel (guru_id, kelas_id, mapel_id) 
VALUES (
    (SELECT id FROM guru WHERE users_id = 5),
    1,  -- ID kelas X IPA
    1   -- ID mapel Matematika
);

-- 4. Verifikasi data
SELECT * FROM guru_mapel 
JOIN guru ON guru_mapel.guru_id = guru.id
JOIN kelas ON guru_mapel.kelas_id = kelas.id
WHERE guru.users_id = 5;
```

---

## 🔧 Code Implementation Checklist

### File Baru yang Dibuat/Diupdate
- [ ] `app/Traits/CanManageAbsensi.php` - **BARU** (trait helper)
- [ ] `app/Http/Controllers/AbsensiController.php` - **UPDATED**
- [ ] `app/Http/Controllers/AgendaController.php` - **UPDATED**

### Verifikasi File `CanManageAbsensi.php`
```php
// Pastikan ada methods ini:
- [ ] canManageAbsensi()
- [ ] getGuruFromUser()
- [ ] teachesClass()
- [ ] getAccessibleClasses()
- [ ] getAccessibleMapelByKelas()
```

### Verifikasi `AbsensiController.php`
```php
// Pastikan ada:
- [ ] use CanManageAbsensi; (trait import)
- [ ] use CanManageAbsensi; (trait usage di class)
- [ ] index() method call canManageAbsensi()
- [ ] getSiswaByKelas() check permissions
- [ ] create() check permissions
- [ ] store() check permissions
- [ ] show() check ownership
- [ ] update() check ownership
```

### Verifikasi `AgendaController.php`
```php
// Pastikan ada:
- [ ] use CanManageAbsensi; (trait import & usage)
- [ ] getGuruKelas() support walikelas
- [ ] getGuruMapel() support walikelas
- [ ] needSignature() support walikelas
- [ ] signForm() support walikelas
- [ ] sign() support walikelas
- [ ] rekap() support walikelas
- [ ] getSiswaTidakHadir() support walikelas
```

---

## 🧪 Functional Testing Checklist

### Test 1: Walikelas Akses Halaman Absensi
```
SCENARIO: Walikelas login dan buka halaman input absensi
EXPECTED: Halaman terbuka tanpa error

Steps:
1. [ ] Login sebagai walikelas (email: fatimah@sekolah.com)
2. [ ] Navigate ke /absensi
3. [ ] Halaman loading dengan dropdown kelas
4. [ ] Dropdown kelas hanya menampilkan kelas yang diampu
5. [ ] Tidak ada error di console
```

**Pass Criteria**: ✅ Halaman terbuka dan dropdown terisi dengan kelas yang diampu

---

### Test 2: Walikelas Input Absensi Baru
```
SCENARIO: Walikelas input data absensi untuk kelas yang diampu
EXPECTED: Data tersimpan dengan guru_id dari walikelas

Steps:
1. [ ] Di halaman /absensi, pilih kelas dari dropdown
2. [ ] Pilih mata pelajaran
3. [ ] Pilih jam pelajaran
4. [ ] Pilih tanggal hari ini
5. [ ] Input status absensi untuk beberapa siswa
6. [ ] Klik tombol "Simpan"
7. [ ] Halaman redirect ke /absensi
8. [ ] Success message muncul: "Data absensi berhasil disimpan"
9. [ ] Di database: SELECT * FROM absensi WHERE guru_id = (walikelas guru_id)
10. [ ] Verifikasi data tersimpan dengan guru_id walikelas
```

**Pass Criteria**: ✅ Data absensi tersimpan di DB dengan guru_id yang benar

---

### Test 3: Walikelas Tidak Bisa Access Kelas Lain
```
SCENARIO: Walikelas coba input absensi untuk kelas yang TIDAK diampu
EXPECTED: Ditolak dengan pesan error

Steps:
1. [ ] Query kelas yang TIDAK diampu oleh walikelas
    SELECT id FROM kelas WHERE id NOT IN 
    (SELECT DISTINCT kelas_id FROM guru_mapel 
     WHERE guru_id = (SELECT id FROM guru WHERE users_id = 5))
2. [ ] Coba akses /absensi?kelas_id=[kelas_lain]
3. [ ] Atau submit form dengan kelas_id dari kelas lain
4. [ ] Verifikasi: Ditampilkan error "Anda tidak memiliki akses ke kelas ini"
```

**Pass Criteria**: ✅ Sistem menolak akses ke kelas yang tidak diampu

---

### Test 4: Walikelas Edit Absensi Milik Sendiri
```
SCENARIO: Walikelas edit data absensi yang sudah dibuat sendiri
EXPECTED: Data terupdate

Steps:
1. [ ] Buka halaman /absensi (lihat list absensi)
2. [ ] Klik untuk edit absensi yang sudah dibuat
3. [ ] Ubah status beberapa siswa
4. [ ] Klik "Simpan"
5. [ ] Success message muncul
6. [ ] Verifikasi di database bahwa data berubah
```

**Pass Criteria**: ✅ Data terupdate dengan baik

---

### Test 5: Guru Masih Bisa Input Absensi
```
SCENARIO: Guru (bukan walikelas) masih bisa input absensi
EXPECTED: Fungsi guru tetap normal

Steps:
1. [ ] Login sebagai guru normal
2. [ ] Buka /absensi
3. [ ] Input absensi seperti biasa
4. [ ] Verifikasi data tersimpan dengan guru_id yang benar
```

**Pass Criteria**: ✅ Guru masih bisa input absensi normal

---

### Test 6: Agenda Controller - Walikelas Bisa Input Agenda
```
SCENARIO: Walikelas juga bisa input data agenda/jadwal
EXPECTED: Halaman input agenda terbuka dan bisa disimpan

Steps:
1. [ ] Login sebagai walikelas
2. [ ] Navigate ke /agenda/create
3. [ ] Pilih kelas yang diampu
4. [ ] Isi form agenda
5. [ ] Submit
6. [ ] Verifikasi di database bahwa data tersimpan
```

**Pass Criteria**: ✅ Walikelas bisa input agenda

---

### Test 7: Agenda Controller - Walikelas Tanda Tangani Agenda
```
SCENARIO: Walikelas bisa tanda tangani agenda
EXPECTED: Halaman sign form terbuka

Steps:
1. [ ] Login sebagai walikelas
2. [ ] Navigate ke /agenda/need-signature
3. [ ] Halaman loading dengan list agenda yang belum ditanda tangani
4. [ ] Klik untuk tanda tangani salah satu agenda
5. [ ] Halaman sign form terbuka
6. [ ] Input tanda tangan digital
7. [ ] Klik "Simpan"
8. [ ] Success message muncul
```

**Pass Criteria**: ✅ Walikelas bisa tanda tangani agenda

---

## 🔐 Security Testing Checklist

### Test S1: SQL Injection Prevention
```
SCENARIO: Coba SQL injection di parameter kelas_id
EXPECTED: Tidak ada data yang leak, error validation

Steps:
1. [ ] Parameter: /absensi?kelas_id=1' OR '1'='1
2. [ ] Verifikasi: Error validation atau tidak ada hasil
3. [ ] Check logs: Tidak ada SQL error yang visible
```

**Pass Criteria**: ✅ Sistem aman dari SQL injection

---

### Test S2: Access Control - Cross User
```
SCENARIO: Walikelas A coba akses absensi dari walikelas B
EXPECTED: Ditolak

Steps:
1. [ ] Login sebagai walikelas A
2. [ ] Absensi ID yang dibuat walikelas B: /absensi/[id_dari_walikelas_B]
3. [ ] Verifikasi: Ditampilkan 404 atau error unauthorized
```

**Pass Criteria**: ✅ Ownership verification bekerja

---

### Test S3: Role-Based Access Control
```
SCENARIO: Siswa/Admin coba akses input absensi
EXPECTED: Ditolak dengan jelas

Steps:
1. [ ] Login sebagai siswa
2. [ ] Coba akses /absensi
3. [ ] Verifikasi: Error message "Akses ditolak" atau redirect
4. [ ] Login sebagai admin (jika ada)
5. [ ] Coba akses /absensi
6. [ ] Verifikasi: Tergantung flow (admin mungkin bisa akses semua)
```

**Pass Criteria**: ✅ Hanya guru & walikelas yang bisa akses

---

## 📊 Database Verification Checklist

### Query Verification

```sql
-- ✅ Check 1: Guru/Walikelas data exist
[ ] SELECT id, users_id, nama_guru FROM guru 
    WHERE users_id IN (SELECT id FROM users WHERE role IN ('guru', 'walikelas'));

-- ✅ Check 2: Guru Mapel mapping exist
[ ] SELECT gm.id, g.nama_guru, k.nama_kelas, m.nama
    FROM guru_mapel gm
    JOIN guru g ON gm.guru_id = g.id
    JOIN kelas k ON gm.kelas_id = k.id
    JOIN mata_pelajaran m ON gm.mapel_id = m.id
    WHERE g.users_id = 5;  -- walikelas user id

-- ✅ Check 3: Absensi tersimpan dengan guru_id correct
[ ] SELECT a.id, g.nama_guru, k.nama_kelas, a.tanggal
    FROM absensi a
    JOIN guru g ON a.guru_id = g.id
    JOIN kelas k ON a.kelas_id = k.id
    WHERE g.users_id = 5;  -- walikelas user id

-- ✅ Check 4: DetailAbsensi linked correct
[ ] SELECT da.id, da.siswa_id, da.status, a.guru_id
    FROM detail_absensi da
    JOIN absensi a ON da.absensi_id = a.id
    WHERE a.guru_id = (SELECT id FROM guru WHERE users_id = 5);
```

---

## 🐛 Debugging Checklist (Jika Ada Error)

### Error: "Data guru tidak ditemukan"
```
[ ] Query: SELECT * FROM guru WHERE users_id = 5;
[ ] If empty: INSERT INTO guru (users_id, nama_guru, nip) VALUES (...);
[ ] If result: Check apakah nama_guru dan nip terisi
```

### Error: "Anda tidak memiliki akses ke kelas ini"
```
[ ] Query: SELECT * FROM guru_mapel WHERE guru_id = [guru_id] AND kelas_id = [kelas_id];
[ ] If empty: INSERT INTO guru_mapel VALUES (...);
[ ] If result: Check apakah kelas_id dan mapel_id valid
```

### Error: "Kombinasi kelas, mapel, dan guru tidak valid"
```
[ ] Query: SELECT * FROM guru_mapel 
    WHERE guru_id = [guru_id] 
    AND kelas_id = [kelas_id] 
    AND mapel_id = [mapel_id];
[ ] If empty: Mapping belum ada di guru_mapel
```

### Error: "Validation failed"
```
[ ] Check request parameters: kelas_id, mapel_id, jampel_id, tanggal
[ ] Verifikasi semuanya ada dan valid
[ ] Check browser console untuk response details
```

---

## ✨ Final Checklist

Sebelum go-live:

### Code Quality
- [ ] Tidak ada PHP error di logs
- [ ] Tidak ada undefined variable
- [ ] Tidak ada SQL error
- [ ] Code format konsisten

### Documentation
- [ ] README updated dengan info walikelas
- [ ] Trait CanManageAbsensi documented
- [ ] Database schema documented

### Testing Completed
- [ ] Semua functional test passed ✅
- [ ] Semua security test passed ✅
- [ ] Cross-browser tested (Chrome, Firefox, Safari)
- [ ] Mobile responsive tested

### Performance
- [ ] Query optimization done (tidak ada N+1 problem)
- [ ] No slow queries
- [ ] Loading time acceptable

### User Training
- [ ] Walikelas trained cara input absensi
- [ ] Admin informed tentang access change
- [ ] Stakeholders informed

---

## 📞 Support & Escalation

Jika ada masalah:

1. **Check logs**: `storage/logs/laravel.log`
2. **Check database**: Query verification di section Database Verification
3. **Check permissions**: Pastikan role dan guru_mapel terisi
4. **Contact developer**: Siapkan error log dan steps to reproduce

---

**Last Updated**: 19 December 2025  
**Status**: ✅ Ready for Testing  
**Tested by**: [Your Name]  
**Test Date**: [Test Date]  
**Result**: ⭕ Pass / ❌ Fail
