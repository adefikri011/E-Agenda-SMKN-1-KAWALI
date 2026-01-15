## ✅ Fitur "Lihat Semua" Modal Untuk Rekap Presensi

### 📋 Deskripsi
Dashboard Guru sekarang menampilkan **3 item pertama** dari Rekap Presensi Hari Ini. Jika ada lebih dari 3 item, akan muncul tombol **"Lihat Semua →"** yang membuka modal dengan daftar lengkap.

### 🎨 Fitur yang Ditambahkan

**File:** `resources/views/guru/dashboard.blade.php`

#### 1. **Dashboard View - Tampil 3 Item Pertama**
- Menggunakan `.take(3)` untuk membatasi tampilan hanya 3 item
- Menampilkan counter "Menampilkan 3 dari X data" jika lebih dari 3
- Tombol "Lihat Semua →" muncul dinamis jika `count > 3`

#### 2. **Modal Popup - Lihat Semua Data**
- Modal modern dengan background overlay semi-transparent
- Menampilkan **semua** data rekap presensi
- Header sticky dan footer untuk navigasi
- Smooth scrolling untuk data yang banyak

#### 3. **Interaktif JavaScript**
- Fungsi `openRekap()` - buka modal
- Fungsi `closeRekap()` - tutup modal
- Close ketika klik di luar modal
- Close dengan tombol ESC
- Disable scroll body saat modal terbuka

### 🎯 Keunggulan
✅ **Tampilan Dashboard Rapi** - Hanya 3 item menghindari scroll panjang
✅ **Akses Lengkap** - Bisa lihat semua data di modal
✅ **UX Baik** - Animasi smooth, responsive, dan intuitif
✅ **Accessibility** - Bisa tutup dengan ESC atau klik di luar
✅ **Styling Profesional** - Tailwind CSS modern dan beautiful

### 📸 Tampilan
- **Dashboard**: 3 item pertama + tombol "Lihat Semua →"
- **Modal**: Semua item dalam scrollable container dengan styling yang sama
- **Responsive**: Bekerja baik di mobile, tablet, desktop

### 🔄 Event Handler
```javascript
- Click tombol "Lihat Semua" → openRekap()
- Click "Tutup" di modal → closeRekap()
- Click di area luar modal → closeRekap()
- Tekan tombol ESC → closeRekap()
```

### 💾 Saved Files
- `resources/views/guru/dashboard.blade.php` - Perbaikan view dan tambah modal
