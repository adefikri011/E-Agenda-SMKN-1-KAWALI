# E-Agenda System Architecture

## System Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     E-AGENDA SYSTEM                         │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              PRESENTATION LAYER (Views)              │  │
│  ├──────────────────────────────────────────────────────┤  │
│  │                                                       │  │
│  │  Admin Panel                Teacher View             │  │
│  │  ├─ /manage-jadwal-guru    ├─ /jadwal-saya         │  │
│  │  ├─ CRUD Interface         ├─ Schedule Cards        │  │
│  │  ├─ Filter & Search        ├─ Time Periods          │  │
│  │  └─ Modal Forms            └─ Error Handling        │  │
│  │                                                       │  │
│  └──────────────────────────────────────────────────────┘  │
│                           ↓↑                                 │
│  ┌──────────────────────────────────────────────────────┐  │
│  │           APPLICATION LAYER (Controllers)            │  │
│  ├──────────────────────────────────────────────────────┤  │
│  │                                                       │  │
│  │  GuruScheduleController          AgendaController   │  │
│  │  ├─ index()                      ├─ index()          │  │
│  │  ├─ getSchedules()               ├─ create()         │  │
│  │  ├─ store() POST                 ├─ getMySchedules() │  │
│  │  ├─ update() PUT                 └─ ... (others)     │  │
│  │  └─ destroy() DELETE                                 │  │
│  │                                                       │  │
│  └──────────────────────────────────────────────────────┘  │
│                           ↓↑                                 │
│  ┌──────────────────────────────────────────────────────┐  │
│  │            BUSINESS LOGIC LAYER (Models)             │  │
│  ├──────────────────────────────────────────────────────┤  │
│  │                                                       │  │
│  │  GuruMapel (Schedule Assignment)                     │  │
│  │  ├─ guru_id          → Guru                          │  │
│  │  ├─ kelas_id         → Kelas                         │  │
│  │  ├─ mapel_id         → MataPelajaran                 │  │
│  │  ├─ jampel_id        → Jampel (TIME PERIOD)          │  │
│  │  └─ Relationships: guru, kelas, mapel, jampel       │  │
│  │                                                       │  │
│  │  Jampel (Time Periods)                               │  │
│  │  ├─ jam_ke           (1-11)                          │  │
│  │  ├─ hari_tipe        (senin, selasa_rabu_kamis, etc) │  │
│  │  ├─ jam_mulai        (06:30, 07:15, etc)            │  │
│  │  ├─ jam_selesai      (07:15, 07:55, etc)            │  │
│  │  └─ Scopes: byHariTipe(), byJamKe()                 │  │
│  │                                                       │  │
│  │  Other Models: Guru, Kelas, MataPelajaran, User, etc │  │
│  │                                                       │  │
│  └──────────────────────────────────────────────────────┘  │
│                           ↓↑                                 │
│  ┌──────────────────────────────────────────────────────┐  │
│  │         PERSISTENCE LAYER (Database)                 │  │
│  ├──────────────────────────────────────────────────────┤  │
│  │                                                       │  │
│  │  Tables:                                             │  │
│  │  ├─ guru_mapel (Schedule Assignments)                │  │
│  │  │  ├─ id, guru_id, kelas_id, mapel_id              │  │
│  │  │  ├─ jampel_id (NEW)                              │  │
│  │  │  └─ timestamps                                    │  │
│  │  │                                                   │  │
│  │  ├─ jam_pelajaran (Time Periods)                    │  │
│  │  │  ├─ id, nama_jam, rentang_waktu                  │  │
│  │  │  ├─ jam_ke, hari_tipe (NEW)                      │  │
│  │  │  ├─ jam_mulai, jam_selesai (NEW)                 │  │
│  │  │  └─ timestamps                                    │  │
│  │  │                                                   │  │
│  │  ├─ guru, kelas, mata_pelajaran (lookup tables)      │  │
│  │  ├─ absensi (depends on jam_pelajaran)               │  │
│  │  └─ agenda (depends on guru_mapel)                   │  │
│  │                                                       │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## Data Flow Diagram

### Creating a Schedule Assignment (Admin)

```
Admin UI
   ↓
Form Submit: {guru_id, kelas_id, mapel_id, jampel_id}
   ↓
/api/guru-schedules (POST)
   ↓
GuruScheduleController::store()
   ├─ Validate data
   ├─ Check for duplicates
   └─ GuruMapel::create()
   ↓
Database: INSERT into guru_mapel
   ↓
Success Response (JSON)
   ↓
Admin Panel Updates
```

### Viewing Schedule (Teacher)

```
Teacher UI: /jadwal-saya
   ↓
Page Load
   ↓
JavaScript: fetch('/api/my-schedules')
   ↓
AgendaController::getMySchedules()
   ├─ Get authenticated user
   ├─ Find guru by user_id
   ├─ Query GuruMapel with relationships
   │  ├─ with(['kelas', 'mapel', 'jampel'])
   │  └─ Map to response structure
   └─ Return JSON
   ↓
Database: SELECT guru_mapel, kelas, mapel, jampel
   ↓
Response Array:
   [
     {
       id, kelas_name, mapel_name,
       jampel_name, rentang_waktu
     }
   ]
   ↓
JavaScript: Render Schedule Cards
   ↓
Display in Browser
```

---

## API Routes & Methods

### ADMIN ROUTES (Requires role:admin)

```
GET     /manage-jadwal-guru
        └─ GuruScheduleController::index()
           └─ Show admin panel view

GET     /api/guru-schedules
        └─ GuruScheduleController::getSchedules()
           └─ Return all schedules with relationships (JSON)

GET     /api/guru-schedules/{id}
        └─ GuruScheduleController::getSchedule($id)
           └─ Return single schedule for edit modal (JSON)

POST    /api/guru-schedules
        └─ GuruScheduleController::store()
           ├─ Validate: guru, kelas, mapel exist
           ├─ Check duplicate (guru+kelas+mapel)
           └─ Create GuruMapel record

PUT     /api/guru-schedules/{id}
        └─ GuruScheduleController::update($id)
           └─ Update schedule assignment

DELETE  /api/guru-schedules/{id}
        └─ GuruScheduleController::destroy($id)
           └─ Delete schedule assignment
```

### TEACHER ROUTES (Requires role:guru)

```
GET     /jadwal-saya
        └─ View (guru/jadwal-saya.blade.php)
           └─ Loads schedules via JavaScript

GET     /api/my-schedules
        └─ AgendaController::getMySchedules()
           ├─ Get authenticated guru
           ├─ Get all GuruMapel for that guru
           ├─ Include kelas, mapel, jampel relationships
           └─ Return JSON array
```

---

## Database Schema (Key Tables)

### guru_mapel (Schedule Assignments)
```sql
CREATE TABLE guru_mapel (
    id              BIGINT PRIMARY KEY AUTO_INCREMENT,
    guru_id         BIGINT NOT NULL,        -- Who teaches
    kelas_id        BIGINT NOT NULL,        -- Which class
    mapel_id        BIGINT NOT NULL,        -- Which subject
    jampel_id       BIGINT NULL,            -- When (time period) [NEW]
    created_at      TIMESTAMP,
    updated_at      TIMESTAMP,
    
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
    FOREIGN KEY (mapel_id) REFERENCES mata_pelajaran(id) ON DELETE CASCADE,
    FOREIGN KEY (jampel_id) REFERENCES jam_pelajaran(id) ON DELETE SET NULL,
    
    UNIQUE KEY(guru_id, kelas_id, mapel_id)
);
```

### jam_pelajaran (Time Periods)
```sql
CREATE TABLE jam_pelajaran (
    id              BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_jam        VARCHAR(50),            -- "Jam 1", "ISTIRAHAT", "MBG"
    rentang_waktu   VARCHAR(20),            -- "06:30-07:15"
    jam_ke          INT NULL,               -- 1, 2, 3, ... 11 [NEW]
    hari_tipe       VARCHAR(30) NULL,       -- "senin", "selasa_rabu_kamis", "jumat" [NEW]
    jam_mulai       TIME NULL,              -- 06:30 [NEW]
    jam_selesai     TIME NULL,              -- 07:15 [NEW]
    created_at      TIMESTAMP,
    updated_at      TIMESTAMP
);
```

---

## Relationship Diagram

```
                           Guru
                            ↑
                            │
                      guru_id (FK)
                            │
┌───────────────────────────┼───────────────────────────┐
│                           │                           │
│                     GuruMapel                         │
│                      (junction)                       │
│                           │                           │
│        ┌──────────────────┼──────────────────┐        │
│        │                  │                  │        │
│   kelas_id (FK)    mapel_id (FK)    jampel_id (FK) [NEW]
│        │                  │                  │        │
│    Kelas            MataPelajaran         Jampel     │
│                                                       │
└───────────────────────────────────────────────────────┘

Additional:
- GuruMapel → Guru (owner of schedule)
- GuruMapel → Kelas (target class)
- GuruMapel → MataPelajaran (subject taught)
- GuruMapel → Jampel (time period) [NEW RELATIONSHIP]
- Jampel has scopes: byHariTipe(), byJamKe()
```

---

## File Organization

```
E-Agenda/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       │   └── GuruScheduleController.php      [NEW/ENHANCED]
│   │       └── AgendaController.php                 [ENHANCED]
│   │
│   └── Models/
│       ├── Jampel.php                              [ENHANCED]
│       ├── GuruMapel.php                           [ENHANCED]
│       └── Guru.php, Kelas.php, MataPelajaran.php
│
├── database/
│   ├── migrations/
│   │   ├── ...existing migrations...
│   │   ├── 2025_12_17_000001_update_jam_pelajaran_table.php     [NEW]
│   │   └── 2025_12_17_000002_add_jampel_id_to_guru_mapel_table.php [NEW]
│   │
│   └── seeders/
│       ├── JampelSeeder.php                        [UPDATED]
│       └── TestScheduleSeeder.php                  [NEW]
│
├── resources/
│   └── views/
│       ├── admin/
│       │   └── guru-schedule.blade.php             [NEW]
│       │
│       └── guru/
│           └── jadwal-saya.blade.php               [NEW]
│
└── routes/
    └── web.php                                     [UPDATED - added 7 routes]
```

---

## Technology Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| Frontend | Blade Templates | Server-side rendering |
| Styling | Tailwind CSS | Responsive design |
| JavaScript | Vanilla JS | Schedule loading, interactivity |
| Backend | Laravel 11 | Framework, routing, middleware |
| ORM | Eloquent | Database abstraction |
| Database | MySQL | Data persistence |
| API | JSON | Data exchange |

---

## Error Handling Strategy

```
Client Error (UI)
    ↓
fetch() → Promise
    ↓
if (!response.ok)
    ├─ Status 4xx: Invalid request
    ├─ Status 5xx: Server error
    └─ Show error message + retry button
    ↓
.catch(error)
    ├─ Network error
    ├─ Parse error
    └─ Show "Error memuat jadwal" + retry

Server Error (API)
    ↓
Controller validation
    ├─ If invalid: return 422 with errors
    └─ If valid: process request
    ↓
Database error
    ├─ Foreign key constraint
    ├─ Duplicate entry
    └─ Return 500 with error message
    ↓
Log error to storage/logs/
    ├─ Timestamp
    ├─ Error message
    ├─ Stack trace
    └─ Request context
```

---

## Performance Considerations

| Aspect | Implementation | Benefit |
|--------|-----------------|---------|
| Query Optimization | Eager loading with `with()` | Reduces N+1 queries |
| Null-Safety | Optional chaining `$item->jampel?->nama_jam` | Prevents errors |
| Lazy Loading | Relationships loaded on demand | Memory efficient |
| Caching | (Potential future) Cache schedule lists | Faster response |
| Validation | Server-side validation | Data integrity |

---

## Security Features

- ✅ **Authentication**: Role-based access control (role:admin, role:guru)
- ✅ **Authorization**: Middleware prevents unauthorized access
- ✅ **Validation**: Server-side input validation
- ✅ **CSRF**: Laravel CSRF tokens (if forms use POST/PUT/DELETE)
- ✅ **SQL Injection**: Eloquent ORM with parameterized queries
- ✅ **Error Messages**: Generic error messages shown to users, detailed logs server-side

---

## Scalability Path

```
Phase 1 (CURRENT):
├─ ✅ Single admin manages all schedules
├─ ✅ Manual schedule creation
└─ ✅ Static schedule variants

Phase 2 (Future):
├─ Role-based admin (department heads)
├─ Bulk import via Excel
└─ Schedule templates

Phase 3 (Future):
├─ Automated conflict detection
├─ Schedule rotation system
└─ Academic year management
```

---

## Deployment Notes

```
Before Production:
1. ✅ Run migrations: php artisan migrate --force
2. ✅ Seed data: php artisan db:seed --class=JampelSeeder
3. ✅ Clear cache: php artisan cache:clear
4. ✅ Optimize: php artisan optimize
5. ✅ Set env: APP_ENV=production

Monitoring:
- ✅ Log file: storage/logs/laravel-*.log
- ✅ Database: Monitor guru_mapel table size
- ✅ API: Monitor /api/my-schedules response time
- ✅ UI: Monitor console errors in browser
```

---

**Created**: December 17, 2025
**Version**: 1.0
**Status**: Production Ready ✅

