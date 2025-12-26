<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

---

# E-Agenda: School Digital Management System

**E-Agenda** is a comprehensive school management system built with Laravel 11, designed to help SMK (vocational schools) manage teacher schedules, lesson plans (agendas), attendance, and grades in a centralized digital platform.

## 🎯 Key Features

### ✅ Schedule Management (JAM PELAJARAN)
- **Admin-controlled**: Only administrators assign teacher schedules
- **Multiple variants**: Different time periods for different days (Senin, Selasa-Rabu-Kamis, Jumat)
- **Teacher view**: Teachers view their assigned schedules and input lesson plans
- **API-driven**: RESTful API for schedule management

### ✅ Lesson Planning (AGENDA)
- Input daily lesson plans
- Track curriculum coverage
- Digital signatures from supervisors
- Export to PDF/Excel

### ✅ Attendance Tracking (ABSENSI)
- Daily student attendance marking
- Automated absence tracking
- Attendance reports

### ✅ Grade Management (NILAI)
- Score entry and management
- Multiple assessment types
- Automated grade calculations

### ✅ User Roles
- **Admin**: System configuration, user management, schedule assignment
- **Teacher (Guru)**: Lesson planning, attendance, grading
- **Student (Siswa)**: View own schedules and grades
- **Principal/Deputy (Kepala Sekolah)**: System overview and reports
- **Class Supervisor (Wali Kelas)**: Class-specific supervision
- **Secretary (Sekretaris)**: Data management and reports

## 🚀 Quick Start

### Requirements
- PHP 8.3+
- MySQL 8.0+
- Composer
- Node.js (for asset compilation)

### Installation

```bash
# Clone repository
git clone <repo-url>
cd E-Agenda

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Run development server
php artisan serve
# Visit: http://127.0.0.1:8000
```

### Default Credentials

```
Admin:
  Email: admin@example.com
  Password: 12345678

Teacher:
  Email: guru@example.com
  Password: 12345678

Teacher (Test):
  Email: guru.test@smk.sch.id
  Password: password
```

## 📚 Documentation

Comprehensive documentation is available:

- **[QUICK_START.md](QUICK_START.md)** - Quick reference guide
- **[JAM_PELAJARAN_DOCUMENTATION.md](JAM_PELAJARAN_DOCUMENTATION.md)** - Schedule system details
- **[SYSTEM_ARCHITECTURE.md](SYSTEM_ARCHITECTURE.md)** - System design and data flow
- **[COMPLETION_SUMMARY.md](COMPLETION_SUMMARY.md)** - Implementation details

## 🗂️ Project Structure

```
app/
├── Http/Controllers/          # Application controllers
│   ├── Admin/
│   │   └── GuruScheduleController.php    # Schedule CRUD
│   └── AgendaController.php               # Lesson planning
├── Models/                    # Eloquent models
│   ├── Guru.php              # Teacher
│   ├── Kelas.php             # Class
│   ├── MataPelajaran.php      # Subject
│   ├── Jampel.php            # Time period
│   ├── GuruMapel.php         # Schedule assignment
│   ├── Agenda.php            # Lesson plan
│   └── Absensi.php           # Attendance

database/
├── migrations/               # Database schema
├── seeders/                  # Sample data
│   ├── JampelSeeder.php      # 30 time periods
│   └── TestScheduleSeeder.php # Test data

resources/views/
├── admin/
│   └── guru-schedule.blade.php      # Schedule manager
└── guru/
    └── jadwal-saya.blade.php        # Teacher view
```

## 🔌 API Endpoints

### Schedule Management

```
GET     /manage-jadwal-guru              # Admin panel
GET     /api/guru-schedules              # List all schedules
POST    /api/guru-schedules              # Create schedule
PUT     /api/guru-schedules/{id}         # Update schedule
DELETE  /api/guru-schedules/{id}         # Delete schedule
```

### Teacher Schedules

```
GET     /jadwal-saya                     # View my schedules
GET     /api/my-schedules                # Get schedules (JSON)
```

### Lesson Planning

```
GET     /agenda                          # List agendas
POST    /agenda                          # Create agenda
GET     /agenda/{id}                     # View agenda
PUT     /agenda/{id}                     # Update agenda
DELETE  /agenda/{id}                     # Delete agenda
```

## 📊 Database Schema

### Key Tables

**guru_mapel** (Schedule Assignments)
- Links guru → kelas → mapel → jampel
- Tracks which teacher teaches which subject to which class at which time

**jam_pelajaran** (Time Periods)
- 30 predefined time slots
- Supports multiple daily variants
- Includes start/end times and day type

**agenda** (Lesson Plans)
- Daily lesson plan entries
- Links to guru_mapel for context
- Supports digital signatures

**absensi** (Attendance)
- Student attendance records
- Linked to jam_pelajaran
- Absence tracking

## 🧪 Testing

Run tests with:

```bash
php artisan test
php artisan test:feature
php artisan test:unit
```

Test data is automatically seeded:

```bash
php artisan db:seed --class=TestScheduleSeeder
```

## 🔒 Security

- ✅ Role-based access control (RBAC)
- ✅ Authentication with Laravel Sanctum
- ✅ CSRF protection
- ✅ Input validation & sanitization
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)

## 🎨 UI/UX

Built with:
- **Tailwind CSS** - Responsive design
- **Alpine.js** - Interactive components
- **Blade Templates** - Server-side rendering

Dark mode and responsive mobile support included.

## 📱 Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari 14+, Chrome Mobile)

## 🐛 Known Issues & Limitations

- Schedule variant changes require admin intervention
- No real-time schedule updates (refresh required)
- Attendance import only supports specific Excel format
- Grade import requires exact column structure

## 🚧 Roadmap

- [ ] Schedule conflict detection
- [ ] Automated schedule optimization
- [ ] Mobile app (React Native)
- [ ] Advanced reporting & analytics
- [ ] Parent portal for grade viewing
- [ ] Integration with government systems

## 🤝 Contributing

Contributions welcome! Please:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📞 Support & Contact

For issues, questions, or feature requests:
- Create GitHub issue
- Email: support@e-agenda.id
- Check documentation files in repository

## 📄 License

E-Agenda is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

Built with [Laravel Framework](https://laravel.com) and [Tailwind CSS](https://tailwindcss.com).

---

**Version**: 2.0.0 (Post Jam Pelajaran Restructuring)
**Last Updated**: December 17, 2025
**Status**: Production Ready ✅

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
