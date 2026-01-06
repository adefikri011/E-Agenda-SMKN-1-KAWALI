# 📊 Panduan Lengkap: Periode Filtering pada Rekap Presensi & Nilai

## 🎯 Ringkasan Fitur

Sistem Rekap Presensi & Nilai telah diupgrade dengan fitur **Periode Filtering** yang sangat powerful. Fitur ini memungkinkan Wali Kelas untuk melihat data presensi dan nilai siswa berdasarkan periode waktu yang berbeda.

---

## ✨ Fitur-Fitur Periode Filtering

### 1. **Semua Data** (All)
- **Icon**: 📋 List Icon
- **Fungsi**: Menampilkan seluruh data presensi dan nilai tanpa filter tanggal
- **Use Case**: Melihat keseluruhan data dari awal semester

### 2. **Hari Ini** (Today)
- **Icon**: 📅 Calendar Day Icon
- **Fungsi**: Menampilkan hanya data yang diinputkan pada hari yang sama
- **Use Case**: 
  - Monitoring presensi hari ini
  - Cek nilai yang baru diinput hari ini

### 3. **Minggu Ini** (This Week)
- **Icon**: 📆 Calendar Week Icon
- **Fungsi**: Menampilkan data dari hari Senin hingga Minggu minggu berjalan
- **Use Case**:
  - Analisis performa mingguan
  - Monitoring kehadiran dalam seminggu
  - Cek perkembangan nilai per minggu

### 4. **Bulan Ini** (This Month)
- **Icon**: 📅 Calendar Alt Icon
- **Fungsi**: Menampilkan data dari tanggal 1 hingga akhir bulan berjalan
- **Use Case**:
  - Rekap bulanan untuk laporan
  - Analisis performa bulanan
  - Identifikasi pola kehadiran dan nilai

### 5. **Semester** 
- **Icon**: 🎓 Graduation Cap Icon
- **Fungsi**: Menampilkan data semester (Januari-Juni atau Juli-Desember)
- **Use Case**:
  - Rekap akhir semester
  - Penilaian akumulatif semester
  - Laporan semester untuk orang tua

### 6. **Custom Periode** (Kustom)
- **Icon**: 📋 List Icon + Custom Date Range
- **Fungsi**: Menampilkan data dalam rentang tanggal yang ditentukan user
- **Use Case**:
  - Analisis periode tertentu (misalnya: setelah libur)
  - Perbandingan antar periode tertentu
  - Laporan khusus dengan rentang tanggal spesifik

---

## 🎨 User Interface Design

### Layout Filter Bar
```
┌─────────────────────────────────────────────────────────────┐
│ 🔍 Filter Data Laporan                                      │
├─────────────────────────────────────────────────────────────┤
│ [📋 Semua] [📅 Hari Ini] [📆 Minggu] [📅 Bulan] [🎓 Semester]│
│                                                              │
│ [Hidden: Custom Date Range Section]                         │
│ [✓ Terapkan Filter] [🔄 Reset]                              │
└─────────────────────────────────────────────────────────────┘
```

### Color Coding
- **Semua Data**: Blue (Primary)
- **Hari Ini**: Green (Success)
- **Minggu Ini**: Purple (Info)
- **Bulan Ini**: Orange (Warning)
- **Semester**: Pink (Special)
- **Custom**: Default style

### Summary Cards
Menampilkan **Periode Aktif** sebagai card utama:
```
┌──────────────────────────┐
│ Periode Aktif            │
│ [Minggu Ini / Custom...] │
│ 📅 [Icon]                │
└──────────────────────────┘
```

---

## 📊 Data yang Difilter

### Untuk Absensi (Presensi)
Filter berdasarkan kolom `tanggal` pada table `absensi`:
- ✅ Total Pertemuan
- ✅ Hadir
- ✅ Sakit
- ✅ Izin
- ✅ Alpa
- ✅ Persentase Kehadiran

### Untuk Nilai
Filter berdasarkan kolom `tanggal` pada table `nilai`:
- ✅ Total Tugas
- ✅ Nilai Rata-rata
- ✅ Nilai Tertinggi
- ✅ Nilai Terendah

### Summary Statistics
Otomatis update sesuai periode yang dipilih:
- ✅ Total Pertemuan (dari absensi)
- ✅ Kehadiran Rata-rata
- ✅ Nilai Rata-rata
- ✅ Total Tugas

---

## 🔧 Cara Menggunakan

### Step 1: Pilih Periode
```
1. Klik salah satu tombol periode (Semua, Hari Ini, Minggu, Bulan, Semester)
2. Button akan menyala/highlight menunjukkan periode yang dipilih
```

### Step 2: Jika Custom Periode
```
1. Klik tombol "Custom" (jika ada)
2. Input "Dari Tanggal" dan "Sampai Tanggal"
3. Validasi otomatis: tanggal awal harus ≤ tanggal akhir
```

### Step 3: Terapkan Filter
```
1. Klik tombol "✓ Terapkan Filter"
2. Halaman akan reload dengan data sesuai filter
3. Summary cards akan update otomatis
4. Table data akan menampilkan only filtered records
```

### Step 4: Reset Filter (Opsional)
```
1. Klik tombol "🔄 Reset"
2. Filter kembali ke "Semua Data"
3. Halaman reload dengan data lengkap
```

---

## 💾 Download Export dengan Filter

Ketika mengekspor data, periode filter yang sedang aktif **JUGA DITERAPKAN**:

### Format Export
1. **PDF** - Professional report format dengan styling
2. **Excel** - For data analysis dan import ke aplikasi lain
3. **CSV** - Plain text format, compatible dengan semua spreadsheet

### Contoh URL dengan Filter
```
/rekap/download/pdf?periode=thisMonth&startDate=&endDate=
/rekap/download/excel?periode=custom&startDate=2024-01-15&endDate=2024-01-20
/rekap/download/csv?periode=semester
```

---

## 🖨️ Print & Refresh

### Print Function
- Keyboard shortcut: **Ctrl + P** (standard browser print)
- Button: **🖨️ Print** di action buttons section
- Included: Filter periode info di header laporan

### Refresh Function
- Button: **🔄 Refresh**
- Memperbarui data tanpa mengganti periode filter
- Useful untuk: Real-time data updates

---

## 🧮 Validasi & Error Handling

### Validasi Custom Periode
```javascript
✓ Cek: Kedua field tanggal harus diisi
✓ Cek: Tanggal awal ≤ Tanggal akhir
✓ Alert: User-friendly warning messages
```

### Error Messages
- **⚠️ "Mohon pilih kedua tanggal"** - Jika field kosong
- **⚠️ "Tanggal awal harus lebih kecil"** - Jika invalid range

---

## 🔌 Technical Implementation

### Backend (RekapController.php)

#### Method: `getDateRangeFromPeriode()`
```php
/**
 * Convert periode string ke date range
 * @param string $periode - Periode type (all, today, thisWeek, thisMonth, semester, custom)
 * @param string $startDate - Custom start date
 * @param string $endDate - Custom end date
 * @return array ['start' => Carbon, 'end' => Carbon]
 */
```

#### Database Queries dengan Filter
```php
// Example: Get absensi with periode filter
$query->whereBetween('tanggal', [$startDate, $endDate]);

// Example: Get nilai dengan periode filter
$query->whereBetween('tanggal', [$startDate, $endDate]);
```

### Frontend (index.blade.php)

#### Key Functions
1. `handlePeriodeChange(periodeValue)` - Handle periode selection
2. `applyFilters()` - Apply dan reload dengan filter
3. `resetFilters()` - Reset ke kondisi default
4. `downloadReport(format)` - Download dengan filter aktif
5. `printReport()` - Print current view
6. `refreshReport()` - Soft reload data

#### URL Query Parameters
```
?periode=thisMonth
?periode=custom&startDate=2024-01-01&endDate=2024-01-31
?periode=semester&startDate=2024-07-01&endDate=2024-12-31
```

---

## 📈 Use Cases & Scenarios

### Scenario 1: Monitoring Harian
- **Periode**: Hari Ini
- **Tujuan**: Cek presensi dan nilai input hari ini
- **Action**: Lihat summary cards untuk quick overview

### Scenario 2: Laporan Mingguan ke Orang Tua
- **Periode**: Minggu Ini
- **Tujuan**: Bagikan progress siswa minggu ini
- **Action**: Download PDF dan kirim via WhatsApp

### Scenario 3: Evaluasi Bulanan
- **Periode**: Bulan Ini
- **Tujuan**: Analisis performa bulanan
- **Action**: Export ke Excel, analisis trend, print report

### Scenario 4: Laporan Semester
- **Periode**: Semester
- **Tujuan**: Penilaian akumulatif semester
- **Action**: Generate report lengkap, arsip, kirim ke admin

### Scenario 5: Analisis Custom
- **Periode**: Custom (15-20 Jan 2024)
- **Tujuan**: Analisis periode pasca-libur
- **Action**: Bandingkan dengan periode sebelumnya

---

## ⚙️ Maintenance & Updates

### Adding New Period
Untuk menambah periode baru, edit:
1. `RekapController.php` - Method `getDateRangeFromPeriode()`
2. `index.blade.php` - Tambah radio button baru
3. `periodeLabels` object - Tambah label di JavaScript

### Database Requirements
Pastikan columns berikut ada di table:
- `absensi.tanggal` (datetime/date)
- `nilai.tanggal` (datetime/date)

---

## 🎓 Tips & Tricks

### 💡 Tip 1: Keyboard Shortcut
- **Ctrl + P**: Open print dialog
- **F5**: Hard refresh halaman

### 💡 Tip 2: Custom Periode Patterns
```
Minggu sebelumnya:
- Dari: [Minggu sebelumnya - Senin]
- Sampai: [Minggu sebelumnya - Minggu]

Sebulan terakhir dari hari ini:
- Dari: [Hari ini - 30 hari]
- Sampai: [Hari ini]

Setelah libur:
- Dari: [Hari pertama masuk]
- Sampai: [Hari ini]
```

### 💡 Tip 3: Efficient Workflow
1. Filter data
2. Review summary cards
3. Check detailed table
4. Export ke Excel untuk analysis lebih lanjut

---

## 📞 Troubleshooting

### Issue: Data tidak muncul saat filter
**Solution**: 
- Cek apakah ada data dalam periode tersebut
- Pastikan tanggal di database sesuai format
- Coba reset filter & coba lagi

### Issue: Download tetap menampilkan data lama
**Solution**:
- Refresh halaman terlebih dahulu
- Cek browser cache: Ctrl+Shift+Del
- Download ulang

### Issue: Custom date range tidak muncul
**Solution**:
- Pastikan memilih periode "Custom" dulu
- Check browser console untuk errors
- Reload halaman

---

## 📝 Changelog

### Version 2.0 (Current)
- ✅ Added periode filtering (all, today, thisWeek, thisMonth, semester, custom)
- ✅ Improved UI with radio button tabs
- ✅ Added periodo info card
- ✅ Export dengan filter support
- ✅ Enhanced JavaScript with validation
- ✅ Print & Refresh buttons

### Version 1.0
- Basic rekap display
- Simple dropdown selector

---

## 🚀 Future Enhancements

- [ ] Save filter preferences (local storage)
- [ ] Quick presets untuk common periods (Last 7 days, Last 30 days)
- [ ] Comparison mode (compare dua periode)
- [ ] Chart visualization per periode
- [ ] Email schedule reports dengan periode tertentu
- [ ] API endpoint untuk mobile app

---

**Last Updated**: January 2025  
**Status**: ✅ Production Ready  
**Support**: Contact System Administrator
