# 📚 SISTEM JADWAL & AGENDA - DOKUMENTASI ALUR

## 🎯 TUJUAN SISTEM

Sistem ini dirancang agar **Admin** mengelola jadwal mengajar guru, sementara **Guru** fokus menginput agenda pembelajaran harian. Ini menciptakan struktur yang rapi dan terorganisir.

---

## 🔄 ALUR SISTEM (FLOW CHART)

```
┌─────────────────────────────────────────────────────────┐
│         SISTEM JADWAL & AGENDA E-AGENDA                │
└─────────────────────────────────────────────────────────┘

═══════════════════════════════════════════════════════════
FASE 1: SETUP JADWAL (Dilakukan 1x oleh ADMIN)
═══════════════════════════════════════════════════════════

┌─────────────────────┐
│  ADMIN LOGIN        │
│ dashboard-admin     │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────────────────────────────┐
│ Klik Menu: Data Master → Kelola Jadwal Guru │
│         Route: /manage-jadwal-guru          │
└──────────┬──────────────────────────────────┘
           │
           ▼
┌──────────────────────────────────────────────────┐
│ Panel Admin Kelola Jadwal Mengajar               │
│ ✅ Tambah Jadwal Baru                           │
│    - Pilih Guru                                 │
│    - Pilih Kelas                               │
│    - Pilih Mata Pelajaran                      │
│    - Pilih Jam Pelajaran (Optional)            │
│ ✅ Edit Jadwal (Ubah kombinasi guru-kelas-mapel)
│ ✅ Hapus Jadwal (Hapus assignment)             │
│ ✅ Filter & Cari (Cari jadwal tertentu)        │
└──────────┬───────────────────────────────────┘
           │
           ▼
┌──────────────────────────────────┐
│ Data Disimpan ke Table:          │
│ guru_mapel (guru_id, kelas_id,   │
│            mapel_id, jampel_id)  │
└──────────────────────────────────┘

═══════════════════════════════════════════════════════════
FASE 2: GURU MELIHAT JADWAL (Daily)
═══════════════════════════════════════════════════════════

┌─────────────────────┐
│  GURU LOGIN         │
│ dashboard-guru      │
└──────────┬──────────┘
           │
           ▼
┌──────────────────────────────────────┐
│ Klik Menu: Jadwal Saya               │
│ Route: /jadwal-saya                  │
└──────────┬───────────────────────────┘
           │
           ▼
┌────────────────────────────────────────────────┐
│ VIEW: Jadwal Mengajar (READ-ONLY)             │
│                                                │
│ Menampilkan SEMUA kombinasi Kelas+Mapel       │
│ yang diatur oleh Admin (dari guru_mapel)      │
│                                                │
│ Contoh:                                       │
│ ┌─────────────────────────────────────────┐   │
│ │ Card 1: Kelas XI RPL                    │   │
│ │         Mata Pelajaran: Basis Data      │   │
│ │         Jam: 08:00-09:30                │   │
│ │         [Tombol: Input Agenda]          │   │
│ └─────────────────────────────────────────┘   │
│                                                │
│ ┌─────────────────────────────────────────┐   │
│ │ Card 2: Kelas XI TKRO                   │   │
│ │         Mata Pelajaran: Teori Chassis   │   │
│ │         Jam: 10:00-11:30                │   │
│ │         [Tombol: Input Agenda]          │   │
│ └─────────────────────────────────────────┘   │
│                                                │
└────────────────────────────────────────────────┘

═══════════════════════════════════════════════════════════
FASE 3: GURU INPUT AGENDA (Per Jadwal)
═══════════════════════════════════════════════════════════

┌─────────────────────────────────────┐
│ Dari "Jadwal Saya", Guru klik:      │
│ [✏️ Input Agenda] di salah satu Card │
└──────────┬────────────────────────────┘
           │
           ▼
┌──────────────────────────────────────────────┐
│ Agenda Harian View                          │
│ Route: /agenda-daily                        │
│                                              │
│ [📅 Date Picker] ← Pilih tanggal            │
│                                              │
│ Menampilkan semua jadwal per hari            │
│ dalam bentuk CARD SCHEDULE                   │
│                                              │
│ Contoh Card:                                │
│ ┌──────────────────────────────────────┐   │
│ │ Kelas: XI RPL                        │   │
│ │ Mapel: Basis Data                    │   │
│ │ Status: ❌ Belum Ada Agenda          │   │
│ │ [+ Tambah Agenda]  [✏️ Edit] [🗑️ Hapus] │
│ └──────────────────────────────────────┘   │
│                                              │
└──────────┬───────────────────────────────────┘
           │ Klik [+ Tambah Agenda]
           ▼
┌─────────────────────────────────────────────┐
│ MODAL FORM: Input Agenda Pembelajaran       │
│                                              │
│ 📌 Kelas: XI RPL (Read-Only)                │
│ 📌 Mata Pelajaran: Basis Data (Read-Only)   │
│ 📌 Jam Pelajaran: [Dropdown]                │
│    ├─ 08:00-09:30                          │
│    ├─ 09:30-11:00                          │
│    └─ 11:00-12:30                          │
│                                              │
│ 📝 Materi Ajar: [Text Input]                │
│    Contoh: "Query SELECT dan WHERE"        │
│                                              │
│ 🎓 Kegiatan Pembelajaran: [Textarea]        │
│    Contoh: "Praktik membuat query..."      │
│                                              │
│ 📌 Catatan: [Optional]                      │
│    Contoh: "Semua siswa hadir"              │
│                                              │
│ [Batal] [💾 Simpan Agenda]                  │
└──────────┬──────────────────────────────────┘
           │ Klik [Simpan]
           ▼
┌─────────────────────────────────┐
│ Data AGENDA Disimpan ke DB:     │
│ (tanggal, materi, kegiatan,     │
│  catatan, guru_id, kelas_id,    │
│  mapel_id, jampel_id)           │
└──────────┬─────────────────────┘
           │
           ▼
┌────────────────────────────────────────────┐
│ Card Berubah Menjadi:                      │
│ ┌──────────────────────────────────────┐  │
│ │ Kelas: XI RPL                        │  │
│ │ Mapel: Basis Data                    │  │
│ │ Status: ✅ Sudah Ada Agenda          │  │
│ │                                      │  │
│ │ Materi: Query SELECT dan WHERE       │  │
│ │ Jam: 08:00-09:30                    │  │
│ │                                      │  │
│ │ [✏️ Edit] [🗑️ Hapus]                │  │
│ └──────────────────────────────────────┘  │
└────────────────────────────────────────────┘

═══════════════════════════════════════════════════════════
FASE 4: GURU EDIT/HAPUS AGENDA (Optional)
═══════════════════════════════════════════════════════════

Guru bisa:
✅ Klik [✏️ Edit] → Modal terbuka dengan data sebelumnya
✅ Klik [🗑️ Hapus] → Agenda dihapus (dengan konfirmasi)
```

---

## 📊 TABEL DATABASE TERKAIT

### 1. **Tabel: `guru_mapel`** (Jadwal Mengajar - Diatur Admin)
```
┌────────────────────────────────────────┐
│ Column        │ Type     │ Keterangan  │
├────────────────────────────────────────┤
│ id            │ INT PK   │ ID Unik     │
│ guru_id       │ INT FK   │ ID Guru     │
│ kelas_id      │ INT FK   │ ID Kelas    │
│ mapel_id      │ INT FK   │ ID Mapel    │
│ jampel_id     │ INT FK   │ ID Jam      │
│ created_at    │ DATETIME │ Dibuat      │
│ updated_at    │ DATETIME │ Diupdate    │
└────────────────────────────────────────┘

Contoh Data:
id | guru_id | kelas_id | mapel_id | jampel_id
1  | 5       | 10       | 3        | 2
2  | 5       | 11       | 3        | 3
3  | 6       | 12       | 5        | 1
```

### 2. **Tabel: `agenda`** (Agenda Pembelajaran - Input Guru)
```
┌──────────────────────────────────────┐
│ Column        │ Type      │ Keterangan│
├──────────────────────────────────────┤
│ id            │ INT PK    │ ID Unik   │
│ guru_id       │ INT FK    │ ID Guru   │
│ kelas_id      │ INT FK    │ ID Kelas  │
│ mapel_id      │ INT FK    │ ID Mapel  │
│ jampel_id     │ INT FK    │ ID Jam    │
│ tanggal       │ DATE      │ Tgl Input │
│ materi        │ TEXT      │ Materi    │
│ kegiatan      │ TEXT      │ Kegiatan  │
│ catatan       │ TEXT      │ Catatan   │
│ created_at    │ DATETIME  │ Dibuat    │
│ updated_at    │ DATETIME  │ Diupdate  │
└──────────────────────────────────────┘

Contoh Data:
id | guru_id | kelas_id | tanggal | materi | jampel_id
1  | 5       | 10       | 2025-01-08 | Query SELECT WHERE | 2
2  | 5       | 11       | 2025-01-08 | Pembukaan Dashboard | 3
```

---

## 🛣️ ROUTE MAP

### **ADMIN ROUTES** (Manage Jadwal)
```
GET  /manage-jadwal-guru
     → View daftar jadwal guru + form tambah/edit

GET  /api/guru-schedules
     → JSON: Semua jadwal (untuk filter & search)

GET  /api/guru-schedules/{id}
     → JSON: Detail jadwal spesifik (untuk edit modal)

POST /api/guru-schedules
     → Tambah jadwal baru (AJAX)

PUT  /api/guru-schedules/{id}
     → Update jadwal (AJAX)

DELETE /api/guru-schedules/{id}
     → Hapus jadwal (AJAX)
```

### **GURU ROUTES** (View & Input)
```
GET  /jadwal-saya
     → View jadwal mengajar (READ-ONLY)

GET  /api/my-schedules
     → JSON: Jadwal guru yang login

GET  /agenda-daily
     → View agenda harian dengan modal form

GET  /api/jampel
     → JSON: Semua jam pelajaran

GET  /api/agendas/{date}
     → JSON: Agenda berdasarkan tanggal

POST /api/agendas
     → Tambah agenda (AJAX)

PUT  /api/agendas/{id}
     → Update agenda (AJAX)

DELETE /api/agendas/{id}
     → Hapus agenda (AJAX)
```

---

## 📱 INTERFACE VIEWS

### **1. Admin: /manage-jadwal-guru**
```
┌─────────────────────────────────────────────────┐
│ 📚 Kelola Jadwal Mengajar Guru                  │
│                                                 │
│ [+ Tambah Jadwal Baru]                         │
│                                                 │
│ Cari Guru: [________]  Filter Kelas: [____]   │
│ Filter Mapel: [____]                           │
│                                                 │
│ ┌─────────────────────────────────────────────┐│
│ │ Guru | Kelas | Mapel | Jam | Aksi         ││
│ ├─────────────────────────────────────────────┤│
│ │ Budi | XI RPL | Basis Data | 08:00-09:30  ││
│ │                               [Edit] [Hapus] ││
│ │ Budi | XI TKRO | Teori Chassis | 10:00-11:30
│ │                               [Edit] [Hapus] ││
│ │ Siti | XII RPL | Jaringan | 12:30-13:30   ││
│ │                               [Edit] [Hapus] ││
│ └─────────────────────────────────────────────┘│
└─────────────────────────────────────────────────┘

Modal Tambah/Edit:
┌─────────────────────────────────────┐
│ Guru: [Dropdown Budi/Siti/...]      │
│ Kelas: [Dropdown XI RPL/XI TKRO/...] │
│ Mapel: [Dropdown Basis Data/...]    │
│ Jam: [Dropdown 08:00/09:30/...]     │
│                  [Batal] [Simpan]   │
└─────────────────────────────────────┘
```

### **2. Guru: /jadwal-saya**
```
┌─────────────────────────────────────────────────┐
│ 📅 Jadwal Mengajar Saya                         │
│                                                 │
│ ℹ️ Jadwal Anda Diatur Oleh Admin               │
│                                                 │
│ ┌────────────────────┐  ┌────────────────────┐ │
│ │ Kelas: XI RPL      │  │ Kelas: XI TKRO     │ │
│ │ Mapel: Basis Data  │  │ Mapel: Teori       │ │
│ │ 🕐 08:00-09:30     │  │ 🕐 10:00-11:30    │ │
│ │ [✏️ Input Agenda]  │  │ [✏️ Input Agenda] │ │
│ └────────────────────┘  └────────────────────┘ │
│                                                 │
│ [+ Input Agenda Pembelajaran]                  │
└─────────────────────────────────────────────────┘
```

### **3. Guru: /agenda-daily**
```
┌──────────────────────────────────────────────┐
│ 📅 Agenda Pembelajaran - Rabu, 08 Januari 2025
│                                              │
│ [< Sebelumnya] [Hari Ini] [Selanjutnya >]  │
│                                              │
│ ┌──────────────────────────────────────────┐ │
│ │ Kelas: XI RPL                            │ │
│ │ Mata Pelajaran: Basis Data               │ │
│ │ Status: ❌ Belum Ada Agenda              │ │
│ │                                          │ │
│ │ [+ Tambah Agenda] [✏️ Edit] [🗑️ Hapus] │ │
│ └──────────────────────────────────────────┘ │
│                                              │
│ ┌──────────────────────────────────────────┐ │
│ │ Kelas: XI TKRO                           │ │
│ │ Mata Pelajaran: Teori Chassis           │ │
│ │ Status: ✅ Sudah Ada Agenda             │ │
│ │                                          │ │
│ │ Materi: Pembukaan Dashboard              │ │
│ │ Jam: 10:00-11:30                       │ │
│ │                                          │ │
│ │ [✏️ Edit] [🗑️ Hapus]                   │ │
│ └──────────────────────────────────────────┘ │
│                                              │
└──────────────────────────────────────────────┘

Modal Tambah/Edit Agenda:
┌────────────────────────────────────────────┐
│ Kelas: XI RPL (Read-Only)                  │
│ Mata Pelajaran: Basis Data (Read-Only)    │
│ Jam Pelajaran: [08:00-09:30 ▼]            │
│                                            │
│ Materi: [________________________]         │
│         Query SELECT dan WHERE             │
│                                            │
│ Kegiatan: [________________________]       │
│           Praktik membuat query...         │
│                                            │
│ Catatan: [________________________]        │
│          Semua siswa hadir                 │
│                                            │
│         [Batal]  [💾 Simpan Agenda]      │
└────────────────────────────────────────────┘
```

---

## 🔐 PERMISSION & ROLE

| Role    | Access                  | Fitur                                    |
|---------|-------------------------|------------------------------------------|
| **Admin** | `/manage-jadwal-guru`  | ✅ Tambah/Edit/Hapus Jadwal Guru      |
| **Guru** | `/jadwal-saya`         | ✅ Lihat Jadwal (Read-Only)            |
| **Guru** | `/agenda-daily`        | ✅ Input/Edit/Hapus Agenda Harian     |
| **Guru** | `/api/my-schedules`    | ✅ API Jadwal Mereka                   |
| **Guru** | `/api/agendas/*`       | ✅ API CRUD Agenda                      |

---

## 🚀 WORKFLOW SUMMARY

### **Untuk Admin:**
1. Login → Dashboard Admin
2. Menu Data Master → Kelola Jadwal Guru
3. Klik "Tambah Jadwal Baru"
4. Pilih: Guru + Kelas + Mapel + Jam (optional)
5. Klik "Simpan"
6. Edit/Hapus jika diperlukan

### **Untuk Guru:**
1. Login → Dashboard Guru
2. Menu → "Jadwal Saya" (lihat semua jadwal)
3. Klik [✏️ Input Agenda] pada salah satu jadwal
4. Atau langsung ke /agenda-daily
5. Pilih tanggal
6. Klik [+ Tambah Agenda] di card kelas
7. Isi: Jam + Materi + Kegiatan + Catatan
8. Klik [Simpan Agenda]
9. Edit/Hapus agenda jika diperlukan

---

## 💾 DATABASE OPERATIONS

### **Create Jadwal (Admin)**
```javascript
POST /api/guru-schedules
{
  "guru_id": 5,
  "kelas_id": 10,
  "mapel_id": 3,
  "jampel_id": 2
}
```

### **Read Jadwal (Guru)**
```javascript
GET /api/my-schedules
// Response:
[
  {
    "id": 1,
    "guru_id": 5,
    "kelas_name": "XI RPL",
    "mapel_name": "Basis Data",
    "jampel_name": "Jam 1",
    "rentang_waktu": "08:00-09:30"
  }
]
```

### **Create Agenda (Guru)**
```javascript
POST /api/agendas
{
  "kelas_id": 10,
  "mapel_id": 3,
  "jampel_id": 2,
  "tanggal": "2025-01-08",
  "materi": "Query SELECT WHERE",
  "kegiatan": "Praktik...",
  "catatan": "Semua hadir"
}
```

---

## ✅ KEUNTUNGAN SISTEM INI

1. **Admin Control** 💪
   - Admin punya kontrol penuh jadwal guru
   - Tidak ada benturan jadwal
   - Lebih mudah diatur

2. **Guru Focus** 🎓
   - Guru fokus input agenda saja
   - Tidak perlu manage jadwal
   - Lebih sederhana & cepat

3. **Terstruktur** 🏗️
   - Setiap guru punya jadwal jelas
   - Setiap jadwal punya agenda
   - Data rapi & terintegrasi

4. **Scalable** 📈
   - Mudah tambah guru/kelas baru
   - Mudah ubah jadwal
   - API sudah siap

---

## 🔧 FILE-FILE PENTING

### Controllers
- `app/Http/Controllers/Admin/GuruScheduleController.php` - Manage jadwal
- `app/Http/Controllers/AgendaController.php` - Agenda CRUD + getMySchedules

### Views
- `resources/views/admin/guru-schedule.blade.php` - Panel admin
- `resources/views/guru/jadwal-saya.blade.php` - View jadwal guru
- `resources/views/guru/agenda/daily.blade.php` - Input agenda

### Routes
- `routes/web.php` - Semua routes di-list di file ini

### Models
- `app/Models/GuruMapel.php` - Relasi guru-kelas-mapel
- `app/Models/Agenda.php` - Model agenda
- `app/Models/Guru.php` - Model guru
- `app/Models/Jampel.php` - Model jam pelajaran

---

**Dibuat oleh:** GitHub Copilot  
**Tanggal:** 17 Desember 2025  
**Status:** ✅ Production Ready
