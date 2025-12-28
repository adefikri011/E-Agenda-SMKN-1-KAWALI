# 🎨 Preview & Features Overview

## Halaman Profile - Visual Layout

```
┌─────────────────────────────────────────────────────────┐
│                    NAVBAR (E-Agenda)                    │
│  Logo  Dashboard  Menu...          [Avatar] [Name/Role] │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                                                           │
│  [Avatar Circle]  Profil Saya                            │
│                   Kelola informasi akun Anda             │
│                                                           │
│  ┌─ Informasi Profil ──── Keamanan ────────────────────┐ │
│  │ 📋 Informasi Profil        🔒 Keamanan Akun         │ │
│  │                                                       │ │
│  │ Nama Lengkap:                    Tips Keamanan:      │ │
│  │ [Input Field]                    [Info Box]          │ │
│  │                                                       │ │
│  │ Email:                           Ubah Password:      │ │
│  │ [Input Field]                    [Card Link]         │ │
│  │                                                       │ │
│  │ Role/Peran:                                          │ │
│  │ [Badge: Guru]                                        │ │
│  │                                                       │ │
│  │ [Batal] [Simpan Perubahan]                          │ │
│  └───────────────────────────────────────────────────────┘ │
│                                                           │
│  Member Sejak  │  Last Updated  │  Status: ✓ Aktif     │
│  Dec 27, 2025  │  Dec 27, 2025  │                       │
│                │                 │                       │
└─────────────────────────────────────────────────────────┘
```

## Halaman Change Password - Visual Layout

```
┌─────────────────────────────────────────────────────────┐
│                    NAVBAR (E-Agenda)                    │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                                                           │
│  ← Kembali ke Profil                                    │
│  Ubah Password                                          │
│  Perbarui password Anda dengan yang baru dan aman       │
│                                                           │
│  ┌─────────────────────────────────────────────────────┐│
│  │ ⓘ Password yang Kuat                               ││
│  │ Gunakan password yang kuat dengan kombinasi...     ││
│  └─────────────────────────────────────────────────────┘│
│                                                           │
│  Password Saat Ini *                                    │
│  [Input Field with Eye Icon]                           │
│  Error message (if any)                                │
│                                                           │
│  Password Baru *                                        │
│  [Input Field with Eye Icon]                           │
│  Error message (if any)                                │
│                                                           │
│  Persyaratan Password:                                  │
│  ✓ Minimal 8 karakter                                  │
│  ✓ Huruf besar dan kecil                               │
│  ✓ Mengandung angka (0-9)                              │
│  ✓ Simbol (!@#$%^&*)                                   │
│                                                           │
│  Konfirmasi Password Baru *                             │
│  [Input Field with Eye Icon]                           │
│  Error message (if any)                                │
│                                                           │
│  [Batal] [Ubah Password]                               │
│                                                           │
│  ┌─ Praktik Terbaik ─────┐  ┌─ Hindari ─────────────┐ │
│  │ ✓ Jangan berbagi      │  │ ✗ Tanggal lahir      │ │
│  │ ✓ Gunakan unik        │  │ ✗ Nama terkenal      │ │
│  │ ✓ Perbarui berkala    │  │ ✗ Pengulangan char   │ │
│  │ ✓ Hindari mudah       │  │ ✗ Sama dengan user   │ │
│  │   ditebak             │  │   name               │ │
│  └───────────────────────┘  └──────────────────────┘ │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

## 🎯 Fitur Interaktif

### 1. Tab Navigation
- Click "Informasi Profil" → Show profile info form
- Click "Keamanan" → Show security section with change password link

### 2. Password Visibility Toggle
- Click eye icon → Toggle between hidden (●●●●) and visible text
- Works in all 3 password fields

### 3. Real-time Password Requirements
- As user types in "Password Baru":
  - ✗ Gray × for unmet requirements
  - ✓ Green ✓ for met requirements
  - Updates dynamically as they type

### 4. Form Validation
- **Frontend**: HTML5 validation + visual feedback
- **Backend**: Laravel validation with custom messages
- Shows errors in red boxes with specific messages

### 5. Alert Messages
- **Success**: Green box with checkmark
- **Error**: Red box with all error messages
- Fade-in animation on success alerts

## 🎨 Color Scheme

### Role Badges:
```
Admin       → 🔴 Red (#dc2626)
Guru        → 🔵 Blue (#2563eb)
Wali Kelas  → 🟣 Purple (#7c3aed)
Sekretaris  → 🟢 Green (#059669)
Siswa       → 🟠 Orange (#f59e0b)
```

### Theme Colors:
```
Primary     → Blue (#3b82f6)
Success     → Green (#10b981)
Error       → Red (#ef4444)
Warning     → Amber (#f59e0b)
Background  → Light Gray (#f3f4f6)
```

## 📱 Responsive Breakpoints

### Desktop (lg: 1024px+)
- Full navbar with all menu items
- Profile dropdown on right
- Two-column layout for security tips

### Tablet (md: 768px+)
- Responsive navigation
- Adjusted padding and margins
- Single column for some sections

### Mobile (< 768px)
- Hamburger menu
- Stacked navigation
- Full-width inputs and buttons
- Mobile-optimized modals
- Single column layout

## 🔐 Security Indicators

### Password Requirements Visual:
```
Before typing:
[] Minimal 8 karakter
[] Huruf besar dan kecil
[] Mengandung angka
[] Simbol

While typing "Test123":
[] Minimal 8 karakter (7 chars, not met)
[] Huruf besar dan kecil (✓ T and e, met!)
[✓] Mengandung angka (✓ 123, met!)
[] Simbol (not met)

Valid password "SecurePass123!":
[✓] Minimal 8 karakter
[✓] Huruf besar dan kecil
[✓] Mengandung angka
[✓] Simbol
→ Form becomes enabled for submission
```

## 🎬 User Flow

### Accessing Profile:
```
1. User logged in
2. Click avatar → Dropdown menu appears
3. Click "Profile" → Redirect to /profile
4. Shows profile info with option to edit
5. Or click "Ganti Password" → Redirect to /change-password
```

### Updating Profile:
```
1. Edit name or email in form
2. Click "Simpan Perubahan"
3. Backend validates data
4. If valid: Update database → Redirect with success message
5. If invalid: Show error messages in red box
```

### Changing Password:
```
1. Enter current password
2. Enter new password (requirements check in real-time)
3. Confirm new password
4. Click "Ubah Password"
5. Backend validates:
   - Current password matches database
   - New password meets all requirements
   - Confirmation matches new password
6. If valid: Hash password → Update database → Redirect with success
7. If invalid: Show specific error messages
```

## 💬 Error Messages (Indonesian)

### Profile Errors:
- "Nama harus diisi"
- "Nama harus berupa teks"
- "Nama maksimal 255 karakter"
- "Email harus diisi"
- "Format email tidak valid"
- "Email sudah terdaftar"

### Password Errors:
- "Password lama harus diisi"
- "Password lama tidak sesuai"
- "Password baru harus diisi"
- "Konfirmasi password tidak sesuai"
- "Password minimal 8 karakter"
- "Password harus mengandung huruf besar dan kecil"
- "Password harus mengandung angka"
- "Password harus mengandung simbol (!@#$%^&*)"

## ✅ Success Messages

- "Profil berhasil diperbarui!" (after updating profile)
- "Password berhasil diubah!" (after changing password)

## 🎓 Learning Resources in Comments

Each component has:
- Detailed HTML comments explaining structure
- Bootstrap/Tailwind class references
- Alpine.js directive explanations
- Blade template syntax notes
- Laravel validation examples

## 🚀 Performance Optimizations

- **Lazy loading**: Images load only when needed
- **CSS optimization**: Only used Tailwind classes included
- **No unnecessary scripts**: Only Alpine.js for interactivity
- **Form validation**: Client + Server side (fail-safe)
- **Caching**: View compilation cached by Laravel

## 🔄 Session Management

- User must be **authenticated** to access profile routes
- Profile shows **current authenticated user** data
- **CSRF token** included in all POST/PUT forms
- **Session timeout** follows Laravel config

---

**Visual Preview Created:** December 27, 2025
