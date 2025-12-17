# QUICK START: Setup Guru Multiple Mapel

## ⚡ 5 Menit Setup

### 1️⃣ **Admin Setup Penugasan**
```
Login Admin → Go to /guru-mapel
Klik "Tambah Penugasan"

Contoh 1: Pak Ahmad ngajar 2 mapel di 7A
─────────────────────────────────────────
Guru: Pak Ahmad
Mapel: IPS
Kelas: 7A
→ Save

Guru: Pak Ahmad
Mapel: PKN
Kelas: 7A
→ Save

ATAU Gunakan Bulk Assign:
─────────────────────────
Klik "Bulk Assign"
Guru: Pak Ahmad
Kelas: 7A
Centang Mapel: IPS, PKN, Sejarah
→ Assign (semua sekaligus)
```

### 2️⃣ **Guru Buat Agenda**
```
Akses /agenda/create

Pilih:
- Tanggal: 15/12/2025
- Jam: 08:00 - 09:30
- Kelas: 7A          ← Dropdown mapel unlock

Mapel options:
┌─────────────────────────────────┐
│ ○ IPS (Guru: Pak Ahmad)        │
│ ○ PKN (Guru: Pak Ahmad)        │
│ ○ Sejarah (Guru: Ibu Siti)    │
└─────────────────────────────────┘

Pilih: IPS
→ Info box show "Pengampu: Pak Ahmad" ✓

ATAU jika ada multiple guru untuk 1 mapel:
┌─────────────────────────────────┐
│ ○ IPS (Guru: Pak Ahmad, Ibu... │
│ ○ PKN (Guru: Pak Ahmad)        │
└─────────────────────────────────┘

Pilih: IPS
→ Modal popup muncul:
  ╔═══════════════════════════════╗
  ║ Pilih Guru Pengampu IPS       ║
  ║ ○ Pak Ahmad                   ║
  ║ ○ Ibu Siti                    ║
  ║                               ║
  ║ [Batal] [Pilih]               ║
  ╚═══════════════════════════════╝

Pilih: Pak Ahmad → Klik Pilih
→ Info box show "Pengampu: Pak Ahmad" ✓

Lanjutkan isi form & Simpan ✓
```

## 📍 URL Routes

| Fitur | URL | Method |
|-------|-----|--------|
| Lihat semua penugasan | `/guru-mapel` | GET |
| Form tambah penugasan | `/guru-mapel/create` | GET |
| Simpan penugasan baru | `/guru-mapel` | POST |
| Form edit penugasan | `/guru-mapel/{id}/edit` | GET |
| Update penugasan | `/guru-mapel/{id}` | PUT |
| Hapus penugasan | `/guru-mapel/{id}` | DELETE |
| Bulk assign | `/guru-mapel/bulk-assign` | POST |

## 🎯 Kunci Fitur

**Sebelum (Lama):**
- Satu guru, satu mapel, satu kelas = one-to-one
- Guru tidak bisa ngajar 2 mapel di satu kelas
- Ribet kalau ada guru yang ngajar multiple mapel

**Sesudah (Baru):**
- Satu guru bisa ngajar multiple mapel di satu kelas ✅
- Satu mapel bisa diajar oleh multiple guru di satu kelas ✅
- Admin panel lengkap untuk manage semua penugasan ✅
- User auto-prompted untuk pilih guru jika ada multiple ✅

## 📊 Contoh Data

```sql
-- Pak Ahmad ngajar IPS & PKN di 7A
INSERT INTO guru_mapel (guru_id, mapel_id, kelas_id) VALUES
(1, 2, 1),    -- Pak Ahmad (id=1), IPS (id=2), 7A (id=1)
(1, 3, 1);    -- Pak Ahmad (id=1), PKN (id=3), 7A (id=1)

-- Ibu Siti juga ngajar IPS di 7A
INSERT INTO guru_mapel (guru_id, mapel_id, kelas_id) VALUES
(2, 2, 1);    -- Ibu Siti (id=2), IPS (id=2), 7A (id=1)
```

**Hasil saat create agenda, pilih kelas 7A, mapel IPS:**
```
Modal: Pilih Guru Pengampu IPS
○ Pak Ahmad
○ Ibu Siti

User pilih → simpan agenda
```

## ✅ Checklist

- [ ] Admin sudah buka `/guru-mapel`
- [ ] Admin sudah assign guru ke mapel (minimal 1 guru per mapel per kelas)
- [ ] Guru buka `/agenda/create`
- [ ] Pilih kelas → mapel dropdown unlock
- [ ] Pilih mapel → guru auto-appear atau modal muncul
- [ ] Simpan agenda berhasil

## 🆘 Jika Ada Error

**Mapel dropdown tidak unlock:**
```bash
php artisan cache:clear && php artisan view:clear
```

**Guru tidak muncul di modal:**
- Check tabel `guru_mapel` punya data untuk kelas+mapel itu
- Buka browser F12 → Network → check `/agenda/get-mapel-by-kelas/1` response

**Duplikasi entry warning:**
- Kombinasi guru+mapel+kelas sudah ada
- Check tabel `guru_mapel` di database

---

**Need full documentation?** Baca `SOLUSI_MULTIPLE_GURU_MAPEL.md`
