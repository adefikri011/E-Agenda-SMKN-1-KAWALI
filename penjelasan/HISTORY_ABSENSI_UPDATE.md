# Dokumentasi Update: History Absensi (Riwayat Absensi)

## Ringkasan Perubahan

Fitur **Input Absensi** telah dikembangkan menjadi **Sistem Manajemen Absensi Lengkap** dengan tiga modul utama:
1. **Dashboard** - Tampilan awal dengan petunjuk dan statistik bulanan
2. **Riwayat Absensi** - Analisis data kehadiran dalam periode tertentu
3. **Petunjuk** - Panduan lengkap penggunaan sistem

---

## Fitur Utama

### 1. **Dashboard (Halaman Awal)**
Tampilan yang user-friendly dengan:
- **Kartu Sambutan** - Pesan selamat datang
- **3 Quick Action Cards**:
  - Input Absensi - Langsung input absensi hari ini
  - Jadwal Saya - Lihat jadwal dan input dari sana
  - Riwayat Absensi - Analisis data kehadiran
- **4 Statistik Ringkas** - Menampilkan data 1 bulan terakhir:
  - Total Catatan Absensi
  - Rata-rata Kehadiran (%)
  - Total Ketidakhadiran
  - Total Siswa Unik
- **Information Box** - Tips penggunaan singkat

### 2. **Riwayat Absensi Tab**
Fitur analisis data dengan:
- **Filter Lengkap**:
  - Rentang tanggal (dari - sampai)
  - Filter Kelas (opsional)
  - Filter Mata Pelajaran (opsional)
  - Auto-update saat filter diubah
- **4 Statistik Detail** - Update real-time sesuai filter
- **Tabel Detail** dengan kolom:
  - Tanggal
  - Kelas
  - Mata Pelajaran
  - Nama Siswa
  - NIS
  - Status (dengan badge warna)

### 3. **Petunjuk Tab**
Panduan lengkap mencakup:
- Cara Input Absensi (2 metode)
- Cara Lihat Riwayat Absensi
- Penjelasan Statistik
- Status Absensi (4 jenis)
- FAQ dengan 3 pertanyaan umum

---

## Design & User Interface

### Prinsip Design
- **Clean & Intuitive**: Interface yang mudah dipahami
- **Tabbed Navigation**: Navigasi antar fitur dengan tab
- **Responsive Design**: Optimal di mobile, tablet, desktop
- **Professional Minimalist**: Warna terbatas, fokus pada data

### Tab Navigation
```
┌─────────────────────────────────────────┐
│  📊 Dashboard  │  📊 Riwayat  │  ❓ Petunjuk  │
└─────────────────────────────────────────┘
```

### Warna Palet
- **Primary**: Blue (#3B82F6)
- **Success**: Green (#22C55E)
- **Warning**: Yellow (#EAB308)
- **Info**: Blue (#3B82F6)
- **Danger**: Red (#EF4444)
- **Neutral**: Gray (#6B7280)

---

## File yang Diubah

### 1. **View**
- `resources/views/absensi/index.blade.php` (Updated)
  - Struktur berubah dari single-view menjadi tabbed-view
  - Menambahkan Dashboard tab
  - Menambahkan Petunjuk tab
  - Menyimpan Riwayat Absensi tab

### 2. **Controller**
- `app/Http/Controllers/AbsensiController.php` (No changes needed)
  - Tetap menggunakan method `index()` dan `getHistory()`
  - View akan handle tab switching di frontend

### 3. **Routes**
- `routes/web.php` (No new routes)
  - Menggunakan route yang sudah ada: `GET /api/absensi/history`

---

## API Endpoint

### `GET /api/absensi/history`

**Parameters:**
```
start_date: string (format: Y-m-d)  - Tanggal mulai
end_date: string (format: Y-m-d)    - Tanggal akhir
kelas_id: int (optional)             - Filter kelas
mapel_id: int (optional)             - Filter mata pelajaran
```

**Response:**
```json
[
  {
    "id": 1,
    "siswa_id": 10,
    "tanggal": "2024-12-20",
    "kelas": {
      "id": 1,
      "nama_kelas": "X A"
    },
    "mapel": {
      "id": 5,
      "nama": "Matematika"
    },
    "siswa": {
      "id": 10,
      "nama_siswa": "Budi Santoso",
      "nis": "001"
    },
    "status": "hadir"
  }
]
```

---

## Cara Penggunaan

### Dari Dashboard
1. **Masuk ke halaman Absensi** - Klik menu "Absensi" di sidebar
2. **Pilih aksi** - Dashboard menampilkan 3 tombol quick action:
   - ✍️ Input Absensi - untuk input absensi baru
   - 📅 Jadwal Saya - untuk melihat jadwal dan input dari sana
   - 📊 Riwayat Absensi - untuk analisis data
3. **Lihat statistik** - Dashboard otomatis menampilkan data 1 bulan terakhir

### Dari Riwayat Tab
1. **Klik tab "Riwayat Absensi"** di halaman
2. **Atur filter**:
   - Tentukan rentang tanggal
   - Pilih kelas (opsional)
   - Pilih mata pelajaran (opsional)
3. **Klik "Tampilkan"** atau filter akan auto-update
4. **Analisis data** menggunakan statistik dan tabel detail

### Dari Petunjuk Tab
1. **Klik tab "Petunjuk"** untuk melihat panduan lengkap
2. **Baca panduan** tentang:
   - Cara input absensi
   - Cara lihat riwayat
   - Penjelasan statistik
   - Status absensi
   - FAQ

---

## Teknologi yang Digunakan

- **Frontend**: 
  - HTML5 (Blade templating)
  - JavaScript (ES6+, AJAX)
  - Tailwind CSS 3
  - Font Awesome (icons)
  
- **Backend**: 
  - Laravel (PHP)
  - Eloquent ORM
  
- **Database**: 
  - Query optimization dengan eager loading
  - Index optimization

---

## Performance Optimization

- ✅ Data diload via AJAX (tanpa page reload)
- ✅ Tab switching instant (no page reload)
- ✅ Dashboard stats load hanya saat tab dibuka
- ✅ History stats load dengan proper error handling
- ✅ Eager loading untuk mengurangi N+1 query
- ✅ Response JSON yang ringkas

---

## Keamanan

- ✅ Protected dengan middleware `auth` dan `role:guru,walikelas`
- ✅ Query dibatasi hanya untuk mata pelajaran yang diajar guru
- ✅ CSRF protection (implicit dari Laravel)
- ✅ Input validation pada form

---

## JavaScript Functions

### `switchTab(tabName)`
Mengganti tab yang aktif dengan animasi smooth
- Menghide semua tab content
- Menampilkan tab yang dipilih
- Update URL tanpa reload
- Trigger load function sesuai tab

### `loadDashboardStats()`
Load statistik untuk bulan saat ini
- Ambil data 1 bulan terakhir
- Update 4 card statistik
- Jalan otomatis saat dashboard tab dibuka

### `loadAbsensiHistory()`
Load data riwayat sesuai filter
- Ambil nilai filter dari form
- Fetch data dari API
- Render tabel dan update statistik

### `updateDashboardStatistics(data)`
Update card statistik dengan data
- Hitung total, rata-rata, unik
- Update DOM dengan hasil

### `updateStatistics(data)`
Update statistik untuk history tab
- Sama seperti dashboard tapi untuk history

---

## Struktur Tab

### 1. Dashboard Tab (`#dashboard-tab-content`)
- Welcome gradient card
- 3 Quick action cards
- 4 Statistik cards
- Tips penggunaan box

### 2. History Tab (`#history-tab-content`)
- Filter form
- 4 Statistik cards
- Data table
- Pagination info

### 3. Petunjuk Tab (`#petunjuk-tab-content`)
- 4 Panduan section
- FAQ collapsible
- Color-coded dengan icons

---

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Tab tidak berpindah | Refresh halaman, atau check browser console |
| Data tidak muncul di riwayat | Pastikan rentang tanggal benar, atau periksa data di database |
| Statistik 0 | Normal jika belum ada data, coba input absensi terlebih dahulu |
| Filter tidak auto-update | Klik tombol "Tampilkan" atau refresh halaman |

---

## Rencana Masa Depan

Fitur yang dapat ditambahkan:
- 📊 Export data ke Excel
- 📈 Grafik statistik absensi
- 🔔 Alert untuk siswa dengan absensi tinggi
- 📱 Mobile app integration
- 🔄 Integrasi dengan sistem poin/reward
- 📧 Email notification
- 📊 Advanced analytics & reporting

---

**Terakhir Diupdate**: 30 Desember 2024
**Versi**: 3.0 (Tabbed Interface)
**Status**: Production Ready ✅
