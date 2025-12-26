# Jam Pelajaran (Schedule) System Documentation

## Overview

The E-Agenda system has been restructured to support multiple daily schedule variants that match real school operations. This allows different classes/days to have different teaching periods (jam pelajaran).

## Database Structure

### New Jam Pelajaran (Time Period) Columns

The `jam_pelajaran` table now includes:
- `jam_ke` (integer): Session number (1-11 depending on day)
- `hari_tipe` (string): Day variant type (senin, selasa_rabu_kamis, jumat)
- `jam_mulai` (time): Actual start time (e.g., 06:30)
- `jam_selesai` (time): Actual end time (e.g., 07:15)

### New GuruMapel Column

- `jampel_id` (foreignId): Link to jam_pelajaran (optional/nullable)

## Schedule Variants

### SENIN (Monday) - 6 Classes + Breaks
1. **Jam 1** (06:30-07:15)
2. **Jam 2** (07:15-07:55)
3. **Jam 3** (07:55-08:35)
4. **Jam 4** (08:35-09:15)
5. **ISTIRAHAT** (09:15-09:30) - Break
6. **Jam 5** (09:30-10:10)
7. **Jam 6** (10:10-10:50)
8. **Jam 7** (10:50-11:30)
9. **MBG** (11:30-13:00) - Maintenance/Activity
10. **ISTIRAHAT** (12:00-12:45) - Break
11. **Jam 8** (12:45-13:20)

### SELASA-RABU-KAMIS (Tues-Wed-Thu)
Similar structure with Pembinasaan Pagi (Morning Guidance) instead of regular Jam 1:
1. **Jam 1 (Pembinasaan Pagi)** (06:30-07:00)
2-8. Regular classes (07:00-11:15)
9. **MBG** (11:15-12:45)
10-11. Breaks and final class

### JUMAT (Friday) - Shorter Day
1. **Jam 1 (Kegiatan Keagamaan)** (06:30-07:00) - Religious Activity
2-7. Regular classes (07:00-10:35)
8. Final class (10:35-11:15)

## API Integration

### Getting Teacher Schedules

**Endpoint**: `GET /api/my-schedules`

**Response**: JSON array of schedule assignments
```json
[
  {
    "id": 1,
    "kelas_id": 7,
    "kelas_name": "10 TKJ",
    "mapel_id": 9,
    "mapel_name": "Networking",
    "jampel_id": 16,
    "jampel_name": "Jam 1",
    "rentang_waktu": "06:30-07:15"
  }
]
```

## Views

### Admin Schedule Manager
**Route**: `/manage-jadwal-guru`
- Create, read, update, delete teacher schedule assignments
- Assign guru to kelas + mapel combination
- Optional: specify jam pelajaran (time period)
- Filter by guru, kelas, mapel names

### Teacher Schedule View
**Route**: `/jadwal-saya`
- Display all assigned schedules (read-only)
- Shows: Class name, Subject name, Time period
- Links to lesson plan input (`/agenda`)
- Error handling with retry button
- Uses `/api/my-schedules` API endpoint

## Models & Relationships

### Jampel Model
- Scopes:
  - `byHariTipe($hariTipe)` - Filter by day type
  - `byJamKe($jamKe)` - Filter by session number
- Attributes:
  - `getDisplayNameAttribute()` - Format display name with time

### GuruMapel Model
- Enhanced fillable: `['guru_id', 'kelas_id', 'mapel_id', 'jampel_id']`
- Relationships:
  - `guru()` - belongsTo Guru
  - `kelas()` - belongsTo Kelas
  - `mapel()` - belongsTo MataPelajaran
  - `jampel()` - belongsTo Jampel (NEW)

## Migrations

### 2025_12_17_000001_update_jam_pelajaran_table.php
- Adds `jam_ke`, `hari_tipe`, `jam_mulai`, `jam_selesai` columns
- Status: ✅ Executed (657.80ms)

### 2025_12_17_000002_add_jampel_id_to_guru_mapel_table.php
- Adds `jampel_id` foreign key to guru_mapel table
- Nullable foreign key (on delete set null)
- Status: ✅ Executed (406.68ms)

## Database Seeders

### JampelSeeder
- **Data**: 30 total jam pelajaran records (11 senin + 11 selasa_rabu_kamis + 8 jumat)
- **Method**: `updateOrCreate()` to avoid FK constraint issues
- **Status**: ✅ Successfully populated

### TestScheduleSeeder
- **Purpose**: Create sample test data for development/testing
- **Data Created**:
  - Test User: guru.test@smk.sch.id (password)
  - Test Guru: Guru Test
  - Test Class: 10 TKJ
  - Test Subject: Networking
  - Test Assignment: Guru assigned to class+subject on Senin Jam 1
- **Status**: ✅ Created

## Implementation Details

### Foreign Key Handling
When populating jam pelajaran data with existing absensi records:
- Used `updateOrCreate()` instead of `truncate()` or `delete()`
- Avoids "Cannot delete or update parent row" FK constraint errors
- Gracefully updates existing records while preserving references

### Null Safety in API Response
The `getMySchedules()` API uses null-safe operators:
```php
'jampel_name' => $item->jampel?->nama_jam,
'rentang_waktu' => $item->jampel?->rentang_waktu,
```
Prevents errors when `jampel_id` is null/not set on a schedule.

## Testing

### Test Credentials
```
Email: guru.test@smk.sch.id
Password: password
Role: guru
```

### Test Workflow
1. Login as test guru (guru.test@smk.sch.id)
2. Navigate to `/jadwal-saya`
3. Should display test schedule: "10 TKJ | Networking | Jam 1 (06:30-07:15)"
4. Click "Input Agenda" to proceed to lesson planning

### Admin Workflow  
1. Login as admin (admin@example.com / 12345678)
2. Navigate to `/manage-jadwal-guru`
3. Create/edit/delete teacher schedule assignments
4. Verify schedules appear in `/jadwal-saya` for assigned teacher

## Files Modified/Created

### Controllers
- `app/Http/Controllers/AgendaController.php` - Added `getMySchedules()` API method
- `app/Http/Controllers/Admin/GuruScheduleController.php` - CRUD API for schedules

### Models
- `app/Models/Jampel.php` - Enhanced with scopes and attributes
- `app/Models/GuruMapel.php` - Added jampel relationship and updated fillable

### Views
- `resources/views/admin/guru-schedule.blade.php` - Admin schedule manager
- `resources/views/guru/jadwal-saya.blade.php` - Guru schedule view

### Database
- `database/migrations/2025_12_17_000001_update_jam_pelajaran_table.php`
- `database/migrations/2025_12_17_000002_add_jampel_id_to_guru_mapel_table.php`
- `database/seeders/JampelSeeder.php`
- `database/seeders/TestScheduleSeeder.php`

### Routes (routes/web.php)
- Admin: `/manage-jadwal-guru` (GET)
- Admin API: `/api/guru-schedules` (GET, POST, PUT, DELETE)
- Guru: `/jadwal-saya` (GET)
- Guru API: `/api/my-schedules` (GET)

## Status Summary

✅ **Database**: Migrations executed, Jampel data populated (30 records), jampel_id added to guru_mapel
✅ **Models**: All relationships defined correctly
✅ **Controllers**: Admin CRUD and Guru API ready
✅ **Views**: Admin manager and Guru view complete
✅ **Testing**: Test data seeder created and executed
✅ **API**: All endpoints working with proper error handling

### Known Behaviors
- schedule assignments without jampel_id still display but with empty time info
- jampel_name will be null if jampel_id not set (handled gracefully in API)
- Admin can create schedules without specifying jam pelajaran (optional field)

## Next Steps (Optional Enhancements)

1. **UI Improvements**:
   - Add schedule conflict detection (same guru, same time period)
   - Display schedule in calendar view format
   - Bulk upload schedules from Excel

2. **Additional Features**:
   - Auto-populate jampel_id based on default class schedule
   - Schedule rotation system for different class arrangements
   - Archive old schedules by academic year

3. **Reporting**:
   - Export schedule to PDF/Excel
   - Generate hourly schedule conflict reports
   - Teacher workload analysis

