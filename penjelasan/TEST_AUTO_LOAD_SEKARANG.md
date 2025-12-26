# 🚀 CARA TEST AUTO-LOAD - LANGSUNG SEKARANG

## Step 1: Buka jadwal-saya
1. Login sebagai guru
2. Klik menu **"Jadwal Saya"**

## Step 2: Cari satu schedule card
- Cari kartu jadwal yang ada
- Lihat tombol biru **"➕ Input Absensi"**

## Step 3: Klik tombol "Input Absensi"
- **PERHATIKAN URL** yang muncul di address bar
- URL harus ada parameter seperti:
  ```
  http://localhost:8000/absensi?kelas_id=1&mapel_id=2&start_jampel_id=3&end_jampel_id=5&tanggal=2025-12-19&auto_load=1
  ```

## Step 4: Buka DevTools Console
- Tekan **F12** 
- Klik tab **"Console"**
- Lihat log messages yang muncul

## Step 5: Cek Log Messages
Harus ada log seperti ini:
```
=== PAGE LOADED ===
📍 Current URL: http://localhost:8000/absensi?kelas_id=1&...
📍 Search params: ?kelas_id=1&mapel_id=2&...
🔍 Parsed Parameters: {kelasId: "1", tanggal: "2025-12-19", mapelId: "2", autoLoad: "1", ...}
✅ AUTO_LOAD MODE ACTIVATED!
✓ Filter section HIDDEN
✓ FormData updated: {tanggal: "2025-12-19", kelas_id: "1", ...}
🎯 Starting auto-load in 300ms...
🚀 Calling autoLoadStudents()
📥 Fetching students untuk kelas: 1
✓ Students loaded: 25 siswa
✓ Student section rendered
```

## Step 6: Apa yang seharusnya terjadi?
✅ **Filter form HILANG** (tidak terlihat)
✅ **Daftar siswa langsung muncul** dengan nama-nama
✅ **Tidak ada alert atau error**
✅ **Header menunjukkan:** Mata Pelajaran, Tanggal, Total Siswa

---

## ❌ Jika ada masalah:

### Problem: Filter form masih terlihat
**Penyebab:** Auto_load tidak terdeteksi
**Debug:** 
- Cek console apakah ada log "AUTO_LOAD MODE ACTIVATED!"
- Jika tidak ada, berarti URL parameters tidak lengkap
- Share screenshot console + URL

### Problem: Ada error "Gagal memuat siswa"
**Penyebab:** Endpoint `/absensi/siswa/{kelas_id}` error
**Debug:**
- Cek Network tab di DevTools
- Lihat response dari API call
- Share error message

### Problem: Siswa loaded tapi tidak ditampilkan
**Penyebab:** renderStudents() error
**Debug:**
- Cek console untuk error messages
- Scroll down di page - mungkin siswa di bawah

---

## 📝 Catatan Penting

- **Jangan reload halaman** kalau sudah klik tombol, tunggu maksimal 5 detik
- **Bersihkan browser cache** jika masih ada masalah (Ctrl+Shift+Del)
- **Buka DevTools sebelum klik** tombol agar bisa lihat semua log messages

---

**LAPORKAN KE SAYA:** Screenshot console + URL + apa yang terjadi
