# 🚀 AUTO-LOAD WORKFLOW TEST GUIDE

## Konteks Perbaikan

Kami telah memperbaiki workflow auto-load untuk "Input Absensi" dari jadwal-saya agar langsung menampilkan daftar siswa **tanpa perlu mengisi form filter**.

## Perubahan yang Dilakukan

### 1. **formData Object** 
- Ditambah field `start_jampel_id` dan `end_jampel_id`
- Sebelumnya: `jampel_id` (tidak ada)
- Sekarang: `start_jampel_id`, `end_jampel_id`

### 2. **loadStudents() Function**
- Memastikan `formData` **selalu di-update dari DOM sebelum validasi**
- Menambah validasi untuk jampel fields
- Memberikan error messages yang lebih spesifik

```javascript
function loadStudents() {
    // 🔴 PASTIKAN FORMDATA SELALU UPDATE DARI DOM SEBELUM VALIDASI
    formData.tanggal = document.getElementById('tanggal').value;
    formData.kelas_id = document.getElementById('kelas_id').value;
    formData.mapel_id = document.getElementById('mapel_id').value;
    formData.start_jampel_id = document.getElementById('start_jampel_id').value;
    formData.end_jampel_id = document.getElementById('end_jampel_id').value;
    
    // ... validasi dilakukan SETELAH formData updated
}
```

### 3. **Auto-Load Flow (DOMContentLoaded)**
Ditingkatkan dengan step-by-step workflow yang jelas:

**STEP 1:** Hide filter section ✓
**STEP 2:** Set form values (kelas, mapel, tanggal) ✓
**STEP 3:** Rebuild jampel options berdasarkan tanggal ✓
**STEP 4:** Set jampel range (with 600ms delay) ✓
**STEP 5:** Update formData ✓
**STEP 6:** Auto-load students (with 300ms delay) ✓

---

## 📋 TESTING CHECKLIST

### ✅ Test 1: Auto-Load dari Jadwal-Saya

**Persiapan:**
- Buka browser (bersihkan cache jika perlu)
- Login sebagai guru
- Buka page "Jadwal Mengajar Saya"

**Langkah:**
1. Cari satu schedule yang ada
2. Klik tombol **"Input Absensi"** (pada card dengan auto_load=1 parameter)

**Expected Result:**
- ✅ Filter form **LANGSUNG HILANG** (display: none)
- ✅ Daftar siswa langsung muncul
- ✅ Tidak ada alert "Pilih kelas terlebih dahulu"
- ✅ Form fields sudah terisi otomatis (tanggal, kelas, mapel, jampel)
- ✅ Student list sudah load dengan nama-nama siswa

**Debugging:**
Jika ada masalah, buka DevTools (F12) dan cek console untuk log messages:
```
=== DOMContentLoaded fired ===
🚀 AUTO_LOAD MODE ACTIVATED - Skipping filter form
✓ Filter section hidden
✓ Form values set
✓ Jampel rebuilt
✓ Setting jampel range after delay
✓ Start jampel set to: [id]
✓ End jampel clamped
✓ End jampel set to: [id]
✓ FormData updated: {tanggal, kelas_id, mapel_id, start_jampel_id, end_jampel_id}
🎯 Calling loadStudents() for auto-load
loadStudents() called, formData: {...}
✓ Students loaded successfully: [count]
```

---

### ✅ Test 2: Normal Mode (Form Filtering)

**Persiapan:**
- Buka page absensi langsung: `http://localhost:8000/absensi`

**Expected Result:**
- ✅ Filter form ditampilkan
- ✅ Tanggal default = hari ini
- ✅ Dropdown kelas kosong
- ✅ Dropdown mapel kosong (sampai kelas dipilih)
- ✅ Dropdown jampel sudah terisi sesuai hari

**Langkah pengujian:**
1. Pilih tanggal (default = hari ini, OK)
2. Pilih kelas
3. Pilih mapel (sesuai dengan guru-mapel relation)
4. Pilih jam mulai dan jam selesai
5. Klik tombol "Lanjutkan"

**Expected Result:**
- ✅ Daftar siswa muncul
- ✅ Form filter masih terlihat (tidak di-hide)

---

### ✅ Test 3: Student List Rendering

Setelah berhasil load students, verifikasi:

- ✅ Jumlah siswa sesuai dengan database
- ✅ Nama siswa ditampilkan dengan benar
- ✅ Dropdown absensi tersedia untuk setiap siswa (hadir/sakit/izin/alpha)
- ✅ Search siswa berfungsi
- ✅ Button "Tandai Semua Hadir" berfungsi
- ✅ Kolom Nilai (jika ada) berfungsi

---

### ✅ Test 4: Save Absensi

**Langkah:**
1. Ubah beberapa status absensi siswa
2. Klik tombol **"Simpan Absensi"**

**Expected Result:**
- ✅ Loading state muncul (spinner di button)
- ✅ Success modal ditampilkan
- ✅ Dapat melihat pesan: "Data absensi berhasil disimpan"
- ✅ Data tersimpan di database
- ✅ User dapat kembali ke jadwal atau input lagi

---

## 🐛 Troubleshooting

### Problem: Alert masih muncul "Pilih kelas terlebih dahulu"

**Kemungkinan penyebab:**
- `ALL_JAMPEL` data tidak ter-load
- `rebuildJampel()` belum selesai ketika kita set jampel values

**Solusi:**
- Cek console untuk melihat pada step mana error terjadi
- Cek di Network tab apakah API `/absensi/siswa/{kelas_id}` respond dengan benar
- Jika ALL_JAMPEL kosong, pastikan jampel data ada di database

### Problem: Filter form tidak hilang

**Kemungkinan penyebab:**
- Parameter `auto_load` tidak diteruskan dengan nilai `1`
- JavaScript condition tidak match

**Solusi:**
- Cek URL apakah ada parameter `auto_load=1`
- Cek di console value dari `autoLoad`, `kelasId`, `mapelId`, dll

### Problem: Siswa tidak ter-load

**Kemungkinan penyebab:**
- Endpoint `/absensi/siswa/{kelas_id}` error
- Siswa belum terdaftar di database

**Solusi:**
- Cek Network tab untuk melihat response dari endpoint
- Verifikasi siswa sudah ada di database untuk kelas tersebut

---

## 📊 Console Log Messages Reference

| Message | Meaning | Status |
|---------|---------|--------|
| `=== DOMContentLoaded fired ===` | Page sudah fully loaded | ℹ️ Info |
| `🚀 AUTO_LOAD MODE ACTIVATED` | Auto-load workflow dimulai | ✅ Good |
| `✓ Filter section hidden` | Filter form berhasil di-hide | ✅ Good |
| `✓ Form values set` | Nilai form sudah di-set | ✅ Good |
| `✓ Jampel rebuilt` | Jampel options sudah di-rebuild | ✅ Good |
| `loadStudents() called` | Fungsi loadStudents() dipanggil | ℹ️ Info |
| `✓ Students loaded successfully` | Siswa berhasil di-load | ✅ Good |
| Alert "Pilih kelas terlebih dahulu" | formData.kelas_id kosong | ❌ Error |
| Alert "Gagal memuat siswa" | Endpoint error | ❌ Error |

---

## 🎯 Alur Lengkap Auto-Load

```
User klik "Input Absensi" dari jadwal-saya
           ↓
URL include parameters: 
  - kelas_id, mapel_id, start_jampel_id, end_jampel_id, tanggal, auto_load=1
           ↓
DOMContentLoaded event fires
           ↓
Check: autoLoad === '1' && kelasId && mapelId && ... ?
           ↓ (YES)
STEP 1: Hide filter section
           ↓
STEP 2: Set form values
           ↓
STEP 3: Rebuild jampel
           ↓
STEP 4: setTimeout(600ms) → Set jampel values + Update formData
           ↓
STEP 5: setTimeout(300ms) → Call loadStudents()
           ↓
loadStudents():
  - Update formData dari DOM
  - Validasi formData
  - Fetch /absensi/siswa/{kelas_id}
  - Render student list
  - Show studentSection
           ↓
✅ User dapat langsung lihat daftar siswa dan input absensi
```

---

## 📝 Notes

- Semua console.log messages sudah ditambahkan untuk debugging
- Timing delays (600ms + 300ms) sudah optimal untuk jampel rendering
- FormData sekarang selalu ter-update sebelum validasi
- Jampel validation sekarang lebih ketat (mengecek start_jampel_id dan end_jampel_id)

---

## ✨ Perubahan File

**File yang dimodifikasi:**
- `/resources/views/absensi/index.blade.php`

**Perubahan spesifik:**
1. formData object initialization (line 182-187)
2. loadStudents() function (line 276-330)
3. DOMContentLoaded auto-load flow (line 351-436)

