# 📅 Jadwal Saya Enhancement - Auto-Fill Absensi & Agenda

## 🎯 Ringkasan Perubahan

Halaman **Jadwal Saya** (Guru) telah ditingkatkan dengan fitur-fitur berikut:

### ✨ Fitur Baru

1. **Modal Input Absensi Cepat**
   - Input absensi langsung dari kartu jadwal tanpa perlu navigasi ke halaman absensi
   - Modal menampilkan daftar lengkap siswa dalam kelas
   - Setiap siswa dapat dicek/di-uncheck untuk status kehadiran
   - Support kolom keterangan untuk setiap siswa

2. **Auto-Fill Data Saat Membuat Agenda**
   - Ketika guru membuat agenda dari jadwal-saya, data otomatis terisi:
     - ✅ Kelas
     - ✅ Mata Pelajaran
     - ✅ Jam Pelajaran (Jam Mulai)

3. **Integrasi Seamless**
   - Tombol "Input Absensi" langsung membuka modal
   - Tombol "Buat Agenda" redirect dengan parameter yang sudah terisi

---

## 📝 Perubahan File

### 1. **jadwal-saya.blade.php**
**Lokasi:** `resources/views/guru/jadwal-saya.blade.php`

#### Perubahan:
- **Menambahkan Modal untuk Input Absensi:**
  ```html
  <div id="absensiModal" class="hidden fixed inset-0...">
      <!-- Modal untuk input absensi langsung -->
  </div>
  ```

- **Update Tombol pada Kartu Jadwal:**
  - Button "📋 Input Absensi" → Membuka modal
  - Button "✏️ Buat Agenda" → Redirect ke create dengan query params
  
- **Menambahkan JavaScript Functions:**
  - `openAbsensiModal()` - Buka modal dengan data jadwal
  - `closeAbsensiModal()` - Tutup modal
  - `loadJampelInfo()` - Load informasi jam pelajaran
  - `loadSiswaUntukAbsensi()` - Load daftar siswa dari kelas
  - `simpanAbsensi()` - Simpan/redirect ke halaman absensi

#### Contoh Kode yang Diubah:

**Sebelum:**
```html
<a href="/absensi?kelas_id=${schedule.kelas_id}...&tanggal=${new Date().toISOString().split('T')[0]}&auto_load=1" 
   class="block px-4 py-2 bg-blue-100...">
    📋 Lihat Absensi
</a>
```

**Sesudah:**
```html
<button type="button" onclick="openAbsensiModal(${schedule.kelas_id}, '${schedule.kelas_name}', 
    ${schedule.mapel_id}, '${schedule.mapel_name}', ${schedule.start_jampel_id}, ${schedule.end_jampel_id})" 
    class="block px-4 py-2 bg-blue-100...">
    📋 Input Absensi
</button>
```

---

### 2. **create.blade.php** (Agenda Creation)
**Lokasi:** `resources/views/guru/agenda/create.blade.php`

#### Perubahan:
- **Menambahkan Auto-Fill Function:**
  ```javascript
  autoFillFromSchedule()
  ```

- **Logic Auto-Fill:**
  - Baca query parameters dari URL: `kelas_id`, `mapel_id`, `start_jampel_id`, `end_jampel_id`
  - Set nilai kelas select
  - Trigger fetch mata pelajaran
  - Set nilai mata pelajaran
  - Set nilai jam pelajaran

#### Contoh Query String:
```
/agenda/create?kelas_id=5&mapel_id=12&start_jampel_id=3&end_jampel_id=4
```

---

## 🔄 Alur Kerja

### Scenario 1: Input Absensi dari Jadwal Saya

```
[Guru membuka Jadwal Saya]
        ↓
[Lihat kartu jadwal dengan tombol "Input Absensi"]
        ↓
[Klik tombol "Input Absensi"]
        ↓
[Modal terbuka dengan daftar siswa]
        ↓
[Guru centang/uncentang siswa yang hadir]
        ↓
[Klik "Simpan Absensi"]
        ↓
[Redirect ke halaman absensi dengan data pre-filled]
```

### Scenario 2: Buat Agenda dari Jadwal Saya

```
[Guru membuka Jadwal Saya]
        ↓
[Lihat kartu jadwal dengan tombol "Buat Agenda"]
        ↓
[Klik tombol "Buat Agenda"]
        ↓
[Redirect ke /agenda/create dengan query params]
        ↓
[Form agenda terbuka dengan data sudah terisi:
  - Kelas ✓
  - Mata Pelajaran ✓
  - Jam Pelajaran ✓]
        ↓
[Guru tinggal isi materi, kegiatan, catatan, tanda tangan]
        ↓
[Simpan agenda]
```

---

## 📋 API Endpoints yang Digunakan

### 1. Load Jam Pelajaran
```
GET /api/jampel
Response: Array of jampel objects
```

### 2. Load Siswa per Kelas
```
GET /absensi/siswa/{kelas_id}
Response: Array of siswa objects
```

### 3. Load Mata Pelajaran per Kelas
```
GET /agenda/get-mapel-by-kelas/{kelasId}
Response: Array of mapel objects with guru info
```

---

## 🎨 UI/UX Improvements

### Modal Design
- **Header:** Gradient blue dengan informasi jadwal
- **Body:** 
  - Info box menampilkan kelas, mapel, jam, tanggal
  - Daftar siswa dengan checkbox dan kolom keterangan
  - Hover effect pada setiap baris siswa
- **Footer:** 
  - Button "Batal" (gray)
  - Button "Simpan Absensi" (blue)

### Responsive Design
- Modal center pada semua ukuran layar
- Max width: 2xl (28rem)
- Scroll untuk daftar siswa jika lebih dari 4 item
- Touch-friendly buttons dan checkboxes

---

## 🔐 Keamanan

✅ **Endpoints sudah terproteksi dengan:**
- Auth middleware
- Role checking (guru, walikelas)
- Query untuk validasi akses kelas

✅ **CSRF Protection:**
- Form POST menggunakan @csrf token

---

## 🧪 Testing Checklist

- [ ] Buka halaman Jadwal Saya sebagai guru
- [ ] Klik tombol "Input Absensi" pada salah satu kartu
- [ ] Verifikasi modal terbuka dengan data yang benar
- [ ] Load daftar siswa dan tampil dengan benar
- [ ] Ubah status kehadiran beberapa siswa
- [ ] Klik "Simpan Absensi" dan verifikasi redirect ke halaman absensi
- [ ] Klik tombol "Buat Agenda" pada kartu jadwal
- [ ] Verifikasi URL memiliki query params yang benar
- [ ] Verifikasi form agenda terbuka dengan data sudah terisi
- [ ] Coba ubah kelas/mapel dan pastikan tidak ada konflik dengan data dari jadwal

---

## ⚙️ Technical Details

### JavaScript Functions Baru

#### `openAbsensiModal(kelasId, kelasName, mapelId, mapelName, startJampelId, endJampelId)`
Membuka modal input absensi dengan data jadwal yang dipilih.

```javascript
// Initialize data
currentAbsensiData = {
    kelas_id: kelasId,
    mapel_id: mapelId,
    start_jampel_id: startJampelId,
    end_jampel_id: endJampelId,
    siswa: {} // { siswa_id: { hadir, keterangan } }
};

// Load jam pelajaran info
loadJampelInfo(startJampelId, endJampelId);

// Load siswa dari kelas
loadSiswaUntukAbsensi(kelasId);

// Show modal
document.getElementById('absensiModal').classList.remove('hidden');
```

#### `loadJampelInfo(startId, endId)`
Mengambil informasi jam pelajaran dari API dan update modal header.

#### `loadSiswaUntukAbsensi(kelasId)`
Mengambil daftar siswa dari kelas dan menampilkan dalam modal dengan checkbox.

#### `simpanAbsensi()`
Menyimpan data absensi dan redirect ke halaman absensi dengan parameter.

#### `autoFillFromSchedule()`
Membaca query parameters dari URL dan auto-fill form agenda creation.

---

## 🚀 Cara Menggunakan

### Untuk User (Guru)

1. **Akses Jadwal Saya:**
   ```
   /jadwal-saya
   ```

2. **Input Absensi dari Modal:**
   - Klik tombol "📋 Input Absensi" pada kartu jadwal
   - Modal terbuka, centang siswa yang hadir
   - Klik "💾 Simpan Absensi"
   - Sistem redirect ke halaman absensi dengan data pre-filled

3. **Buat Agenda dengan Auto-Fill:**
   - Klik tombol "✏️ Buat Agenda" pada kartu jadwal
   - Form agenda terbuka dengan kelas dan mapel sudah terisi
   - Isi detail agenda lainnya
   - Simpan agenda

### Untuk Developer

1. **Modifikasi Modal:**
   Edit HTML modal di `jadwal-saya.blade.php` (line ~79-135)

2. **Modifikasi Fungsi JavaScript:**
   Edit script functions di `jadwal-saya.blade.php` (line ~138+)

3. **Modifikasi Auto-Fill:**
   Edit function `autoFillFromSchedule()` di `create.blade.php`

---

## 📌 Notes

- Query parameters untuk agenda creation: `kelas_id`, `mapel_id`, `start_jampel_id`, `end_jampel_id`
- Modal absensi menggunakan API `GET /absensi/siswa/{kelas_id}` untuk load siswa
- Semua data siswa di-fetch saat modal dibuka untuk user experience yang smooth
- Auto-fill function memiliki delay 500ms untuk memastikan mapel sudah ter-load

---

## 🐛 Troubleshooting

### Modal tidak muncul?
- Pastikan JavaScript tidak ada error di console
- Verifikasi element `#absensiModal` ada di HTML
- Cek apakah class `hidden` ter-apply dengan benar

### Data siswa tidak ter-load?
- Cek apakah endpoint `/absensi/siswa/{kelas_id}` berfungsi
- Verifikasi response dari API dalam Network tab
- Pastikan kelas memiliki siswa yang terdaftar

### Auto-fill tidak bekerja?
- Cek URL query parameters dengan console: `console.log(window.location.search)`
- Verifikasi parameter names sama dengan yang di-expect
- Pastikan form elements memiliki correct `id` dan `name`

---

## 📞 Support

Untuk pertanyaan atau masalah, hubungi tim development.
