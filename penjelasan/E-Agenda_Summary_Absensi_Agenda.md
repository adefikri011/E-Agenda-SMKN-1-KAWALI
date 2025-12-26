# Ringkasan Sistem E-Agenda (Absensi & Agenda)

Dokumen ini merangkum keseluruhan sistem pada project Anda dengan fokus utama: alur Absensi dan Agenda kelas. File ini dibuat supaya mudah dibagikan lewat WhatsApp (file Markdown/teks).

---

**1. Tujuan Singkat**
- Sistem mencatat jadwal (agenda) pengajaran dan absensi siswa.
- Role utama: `admin`, `guru`, `sekretaris`, `walikelas`, `siswa`.
- Walikelas juga berperan sebagai guru untuk akses tertentu (input absensi & agenda pada kelas yang diampu).

---

**2. Arsitektur & Komponen Utama**
- Laravel backend (Model-View-Controller).
- Database: tabel utama terkait absensi/agenda: `absensi`, `detail_absensi`, `agenda`, `guru_mapel`, `kelas`, `jam_pelajaran`, `mata_pelajaran`, `guru`, `users`, `siswa`.
- Authorization: peran/role (menggunakan metode `hasRole(string)` di user model).
- Trait riil: `app/Traits/CanManageAbsensi.php` — pusat logika izin guru/walikelas.

---

**3. Alur Sistem: Absensi (step-by-step)**
1. Akses UI/API
   - Route penting: `GET /absensi` (index), `GET /absensi/create`, `POST /absensi` (store), `PUT /absensi/{id}`.
   - Hanya role `guru` (dan walikelas yang juga guru pada kelas terkait) yang dapat membuat/mengubah absensi.
2. Validasi dan Otorisasi
   - Sistem memeriksa `auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')`.
   - Trait `CanManageAbsensi` mengambil `Guru` yang terkait dengan `User` (mengembalikan guru record).
   - Cek hubungan `GuruMapel` untuk memastikan guru/walikelas mengampu kelas dan mapel yang dipilih.
3. Pembuatan Absensi
   - Buat record di `absensi` (kolom: `kelas_id`, `guru_id`, `mapel_id`, `jampel_id`/`start_jampel_id`/`end_jampel_id`, `tanggal`, `jam`, `pertemuan` dll).
   - Buat `detail_absensi` untuk masing-masing `siswa` dalam kelas (status: hadir/izin/sakit/alpha).
4. Tampilan & Eksport
   - UI menampilkan absensi hari ini, ringkasan per kelas, dan menyediakan ekspor (mis. Excel/PDF) sesuai izin.

Catatan teknis:
- Model `Absensi` memiliki relasi `kelas()`, `guru()`, `mapel()`, `jampel()`.
- `DetailAbsensi` menyimpan tiap siswa dan keterangannya (`status`, `keterangan`).

---

**4. Alur Sistem: Agenda (step-by-step)**
1. Akses & Hak Akses
   - Route penting: `GET /agenda`, `POST /agenda`, `GET /agenda/{id}`, `PUT /agenda/{id}`, `DELETE /agenda/{id}`.
   - Middleware route: `auth` + `role:guru,sekretaris,walikelas` untuk akses agenda.
2. Pembuatan Agenda
   - User (guru/walikelas/sekretaris) membuat agenda dengan kolom: `tanggal`, `jampel_id`, `kelas_id`, `mata_pelajaran`, `materi`, `kegiatan`, `catatan`, `tanda_tangan`, `pembuat`.
   - Field `pembuat` menentukan apakah pembuat adalah `guru` atau `siswa` (logika: jika role guru/walikelas -> `guru`).
3. Validasi Kelas/Mapel
   - Jika pembuat adalah guru/walikelas, sistem memeriksa `GuruMapel` untuk memastikan guru mengampu kelas/mapel tersebut.
4. Tanda Tangan Digital
   - Agenda dapat memiliki `tanda_tangan` (longText), `sudah_ttd`, `ditandatangani_oleh`, `waktu_ttd`.
   - Tanda tangan dapat diupload atau disimpan sebagai data URL; controller mengelola verifikasi dan menyimpan path/URL.
5. Rekap & Export
   - Fitur `rekap`, `exportPdf`, `exportExcel` tersedia dan menerapkan filter (tanggal, kelas, mapel, status_ttd).

---

**5. Alur Interaksi Antara Agenda & Absensi**
- Agenda dibuat untuk mencatat rencana/rekam kegiatan pengajaran pada tanggal/jampel tertentu.
- Sebelum atau sesudah membuat agenda, guru/walikelas dapat membuat absensi untuk jampel/kelas yang sama.
- Widget "agenda/detail" (API `getDetail`) menggabungkan informasi agenda, jam, kelas, dan memberikan indikator apakah absensi hari itu sudah ada (`ada_absensi_hari_ini`).

---

**6. Database — Tabel & Kolom Penting**
- `absensi` (id, kelas_id, guru_id (users), mapel_id, tanggal, jam, jampel_id/start/end_jampel, pertemuan, timestamps)
- `detail_absensi` (id, absensi_id, siswa_id, status, keterangan)
- `agenda` (id, kelas_id, users_id, jampel_id, tanggal, mata_pelajaran, materi, kegiatan, catatan, tanda_tangan, pembuat, status_ttd, sudah_ttd, guru_ttd_id, ditandatangani_oleh, waktu_ttd)
- `guru_mapel` (id, guru_id, kelas_id, mapel_id) — menentukan guru mengampu mapel di kelas tertentu.

Referensi migrations: `database/migrations/2025_12_05_023613_create_absensi_table.php`, `2025_12_05_022537_create_agenda_table.php`, `2025_12_14_054654_create_guru_mapel_table.php`.

---

**7. File & Lokasi Kode Penting**
- Trait izin: `app/Traits/CanManageAbsensi.php`
- Controller Absensi: `app/Http/Controllers/AbsensiController.php`
- Controller Agenda: `app/Http/Controllers/AgendaController.php`
- Model: `app/Models/Absensi.php`, `app/Models/DetailAbsensi.php`, `app/Models/Agenda.php`, `app/Models/Guru.php`, `app/Models/GuruMapel.php` (jika ada)
- Routes: `routes/web.php` (banyak route yang sudah disiapkan untuk role berbeda)
- Views: `resources/views/...` (termasuk navbar: `resources/views/layout/navbar.blade.php` yang sudah diperbarui agar walikelas melihat menu Agenda)

---

**8. Flow Diagram Sederhana (urutan aksi)**
- Login -> Pilih menu Agenda/Absensi -> Form validasi -> Controller memeriksa role & hubungan `GuruMapel` -> Simpan ke DB -> Buat/Perbarui `detail_absensi` atau `tanda_tangan` -> UI menampilkan rekap/ekspor

---

**9. Permission & Keamanan**
- Gunakan `hasRole('guru') || hasRole('walikelas')` untuk multi-role check (library/spatie biasanya menerima array, tapi implementasi Anda menggunakan single string).
- Saat membuat/ubah data: selalu verifikasi kepemilikan (guru hanya boleh memodifikasi record untuk kelas yang diaampu).
- Validasi input pada controller sebelum menyimpan.

---

**10. Cara Pakai / Langkah Cepat untuk Guru / Walikelas**
1. Login.
2. Buka `Agenda` untuk membuat catatan per jam/pelajaran.
3. Setelah membuat agenda, buka `Absensi` -> pilih kelas -> isi status tiap siswa.
4. Gunakan `Rekap` / `Export` untuk mengunduh laporan.

---

**11. Troubleshooting Umum**
- Jika `Call to unknown method: date::format()` muncul: pastikan kolom `tanggal` dicasting di model (`protected $casts = ['tanggal' => 'date']`) atau gunakan `\Carbon\Carbon::parse()` sebelum `->format()`.
- Jika walikelas tidak melihat menu: periksa `navbar.blade.php` dan middleware route (`role:walikelas` di `routes/web.php`).
- Hak akses: pastikan `guru_mapel` berisi relasi guru-kelas-mapel yang benar agar guru/walikelas bisa mengakses kelas.

---

**12. File yang Saya Buat / Ubah (penting)**
- `app/Traits/CanManageAbsensi.php` (trait untuk izin walikelas/guru)
- `app/Http/Controllers/AbsensiController.php` (update untuk gunakan trait)
- `app/Http/Controllers/AgendaController.php` (perbaikan hasRole, tanggal, duplikasi jampel)
- `resources/views/layout/navbar.blade.php` (tampilkan menu Agenda untuk walikelas)

---

**13. Cara Membagikan (WhatsApp)**
- Opsi 1: Kirim file Markdown ini (`E-Agenda_Summary_Absensi_Agenda.md`) sebagai attachment lewat WhatsApp Desktop atau Telegram/Email.
- Opsi 2: Buka file, copy seluruh isi, paste di pesan WhatsApp (jika terlalu panjang, kirim sebagai file lebih baik).

---

**14. Rekomendasi & Next Steps**
- Buat endpoint API dokumentasi (Postman collection) agar mudah dibagikan.
- Tambahkan unit/integration tests untuk alur `store` absensi dan `store` agenda.
- Pastikan backup DB sebelum migrasi perubahan besar.

---

Jika Anda mau, saya akan:
- Menggabungkan dokumentasi ini menjadi PDF (lebih nyaman dishare), atau
- Menyederhanakan versi teks untuk broadcast WhatsApp, atau
- Membuat Postman collection dengan endpoint penting.

Katakan pilihan Anda (PDF / versi singkat / Postman), saya lanjutkan pembuatan dan akan menyimpan file ke workspace. 
