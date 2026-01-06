# 🎨 Visual Guide: Periode Filtering UI Components

## 📱 Layout Structure

### Full Page Layout
```
┌─────────────────────────────────────────────────────────────────┐
│                                                                   │
│  📊 Rekap Presensi & Nilai                                      │
│  Kelas: [Kelas Name] | Total Siswa: [Count]                   │
│                                                                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  🔍 FILTER DATA LAPORAN                                          │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ [📋 Semua] [📅 Hari] [📆 Minggu] [📅 Bulan] [🎓 Semester]  │ │
│  │                                                              │ │
│  │ [Custom Date Range - Hidden unless selected]               │ │
│  │                                                              │ │
│  │ [✓ Terapkan Filter] [🔄 Reset]                              │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  📊 Summary Cards (4 columns, responsive to 2/1 on mobile)       │
│  ┌──────────────┬──────────────┬──────────────┬──────────────┐   │
│  │ Periode Info │ Total        │ Kehadiran    │ Nilai        │   │
│  │ Aktif        │ Pertemuan    │ Rata-rata    │ Rata-rata    │   │
│  │              │              │              │              │   │
│  │ [Minggu Ini] │ [47]         │ [91.2%]      │ [82.5]       │   │
│  └──────────────┴──────────────┴──────────────┴──────────────┘   │
│                                                                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  📥 ACTION BUTTONS                                               │
│  [📄 PDF] [📊 Excel] [📋 CSV] | [🖨️ Print] [🔄 Refresh]        │
│                                                                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  📋 LAPORAN RINGKASAN                                            │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ 👥 Ringkasan Kehadiran per Siswa                             │ │
│  │ Data presensi harian siswa                                   │ │
│  │                                                              │ │
│  │ [Tabel dengan scroll horizontal untuk mobile]               │ │
│  │ #  | Nama | NIS | Pertemuan | Hadir | Sakit | ... | %     │ │
│  │ 1  | ... | ... | ...       | ...   | ...   | ... | ...   │ │
│  │ 2  | ... | ... | ...       | ...   | ...   | ... | ...   │ │
│  │                                                              │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  📈 RINGKASAN NILAI PER SISWA                                   │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ [Similar table structure as attendance]                     │ │
│  │ #  | Nama | NIS | Total | Rata-rata | Tertinggi | Terendah │ │
│  │ 1  | ... | ... | ...   | ...       | ...       | ...      │ │
│  │ 2  | ... | ... | ...   | ...       | ...       | ...      │ │
│  │                                                              │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🎯 Filter Bar Component Details

### Desktop View (md and above)
```
┌───────────────────────────────────────────────────────────────┐
│ 🔍 Filter Data Laporan                                        │
├───────────────────────────────────────────────────────────────┤
│ ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐        │
│ │ 📋 S   │ │ 📅 Hari│ │ 📆 Min │ │ 📅 Bul │ │ 🎓 Sem │        │
│ │ emua   │ │ Ini    │ │ ggu   │ │ an Ini │ │ ester │        │
│ │        │ │        │ │ Ini   │ │        │ │       │        │
│ └────────┘ └────────┘ └────────┘ └────────┘ └────────┘        │
│                                                               │
│ [Custom Date Range Section - Hidden]                         │
│                                                               │
│ [✓ Terapkan Filter]  [🔄 Reset]                              │
└───────────────────────────────────────────────────────────────┘
```

### Mobile View (cols-2)
```
┌────────────────────────────────┐
│ 🔍 Filter Data Laporan         │
├────────────────────────────────┤
│ ┌──────────┐ ┌──────────┐      │
│ │ 📋 Semua │ │ 📅 Hari  │      │
│ └──────────┘ └──────────┘      │
│ ┌──────────┐ ┌──────────┐      │
│ │ 📆 Minggu│ │ 📅 Bulan │      │
│ └──────────┘ └──────────┘      │
│ ┌──────────┐                   │
│ │ 🎓 Sem   │                   │
│ └──────────┘                   │
│                                │
│ [✓ Apply] [🔄 Reset]           │
└────────────────────────────────┘
```

---

## 🎨 Color Coding & States

### Periode Button States

#### UNSELECTED
```
┌──────────────┐
│ 📅 Hari Ini  │  Border: gray-300 (#d1d5db)
│              │  BG: white
│              │  Text: gray-700
│              │  Hover: border → blue-400
└──────────────┘
```

#### SELECTED (Active)
```
┌──────────────┐
│ ✓ 📅 Hari Ini │  Border: green-600 (#16a34a) 
│              │  BG: white
│              │  Text: green-600 (#16a34a)
│              │  Box-shadow: glow effect
└──────────────┘
```

### Color Mapping
```
Periode          │ Border Color │ Text Color │ Icon
─────────────────┼──────────────┼────────────┼──────────
Semua            │ blue-600     │ blue-600   │ 📋
Hari Ini         │ green-600    │ green-600  │ 📅
Minggu Ini       │ purple-600   │ purple-600 │ 📆
Bulan Ini        │ orange-600   │ orange-600 │ 📅
Semester         │ pink-600     │ pink-600   │ 🎓
```

---

## 📊 Summary Cards Component

### Period Info Card (NEW)
```
┌────────────────────────────────┐
│ Periode Aktif                  │
│ (text-indigo-700, uppercase)   │
│                                │
│ Minggu Ini                     │ ← Large bold text
│ (text-indigo-900)              │
│                                │
│ 📅 [Indigo Icon]               │
└────────────────────────────────┘
```

### Standard Stats Cards (Updated Styling)
```
┌────────────────────────────────┐
│ Total Pertemuan    📅           │
│ (text: gray-600)               │
│                                │
│ 47                             │ ← Large number
│ (text-2xl font-bold)           │
│                                │
│ 📅 [Blue Icon]                 │
└────────────────────────────────┘
```

### Card Color Scheme
```
Card Type              │ Background │ Icon BG    │ Icon Color
───────────────────────┼────────────┼────────────┼────────────
Period Info            │ indigo-50  │ indigo-200 │ indigo-600
Total Pertemuan        │ white      │ blue-100   │ blue-600
Kehadiran Rata-rata    │ white      │ green-100  │ green-600
Nilai Rata-rata        │ white      │ yellow-100 │ yellow-600
Total Tugas            │ white      │ purple-100 │ purple-600
```

---

## 🔢 Responsive Breakpoints

### Filter Buttons
```
Device      │ Grid Columns │ Layout
────────────┼──────────────┼─────────────────────
Mobile      │ 2 cols       │ Stacked 2x3
Tablet      │ 3 cols       │ Stacked 2 rows
Desktop     │ 5 cols       │ All in 1 row
```

### Summary Cards
```
Device      │ Grid Columns │ Cards per Row
────────────┼──────────────┼──────────────
Mobile      │ 1 col        │ 1 card
Tablet      │ 2 cols       │ 2 cards
Desktop     │ 4 cols       │ 4 cards
```

### Tables
```
Device      │ Behavior
────────────┼─────────────────────────────
Mobile      │ Horizontal scroll enabled
Tablet      │ Horizontal scroll enabled
Desktop     │ Full width, no scroll needed
```

---

## 🔄 State Transitions & Animations

### When User Clicks Periode Button
```
1. Click Event
   ↓
2. Fade-in animation (200ms)
   ↓
3. Button highlight/border change
   ↓
4. If custom → show date input fields (slide-down)
   ↓
5. Ready for "Terapkan Filter"
```

### When User Clicks "Terapkan Filter"
```
1. Validation check
   ├─ If error → Toast warning
   └─ If ok ↓
2. Loading state
   ├─ Button text: "Loading..."
   ├─ Button disabled
   └─ Spinner animation ↓
3. URL build with query params
   ↓
4. Page reload
   ↓
5. Data re-fetched from server
   ↓
6. Cards & tables update
   ↓
7. Animation: Fade-in for new data
```

### When Download/Print Clicked
```
1. Button click
   ↓
2. Loading state (500ms)
   ├─ Button text: "Loading..."
   ├─ Spinner animation
   └─ Button disabled ↓
3. Action triggered
   ├─ Download: Open new window
   ├─ Print: Browser print dialog
   └─ Refresh: Page reload ↓
4. Button state restored (1s)
   ├─ Original text
   └─ Button enabled
```

---

## 🎯 Custom Date Range Component

### Hidden State (Default)
```
ID: customDateRangeSection
Class: hidden
Display: none
```

### Visible State (When Custom Selected)
```
┌─────────────────────────────────────────┐
│ Pilih Rentang Tanggal                   │
├─────────────────────────────────────────┤
│ ➡️ Dari Tanggal     ⬅️ Sampai Tanggal   │
│                                         │
│ [Date Picker]       [Date Picker]       │
│ YYYY-MM-DD          YYYY-MM-DD          │
│                                         │
│ Validation on apply:                    │
│ ✓ Both fields must have value           │
│ ✓ Start date ≤ End date                 │
│ ✓ Show error toast if invalid           │
└─────────────────────────────────────────┘
```

---

## 📬 Toast Notification Component

### Warning Toast
```
┌─────────────────────────────────────┐
│ ⚠️ Mohon pilih kedua tanggal          │
│ (yellow-50 bg, yellow-200 border)    │
│ Duration: 3 seconds                  │
│ Animation: Fade-in, auto-dismiss      │
└─────────────────────────────────────┘
```

### Info Toast
```
┌─────────────────────────────────────┐
│ ℹ️ Data berhasil difilter             │
│ (blue-50 bg, blue-200 border)        │
│ Duration: 3 seconds                  │
│ Animation: Fade-in, auto-dismiss      │
└─────────────────────────────────────┘
```

---

## 📊 Data Table Enhancements

### Header Styling
```
┌─────────────────────────────────────────────────────────────┐
│ 👥 Ringkasan Kehadiran per Siswa                            │
│ Data presensi harian siswa                                  │
│                                                             │
│ ← gradient-to-r from-blue-50 to-blue-100                   │
│ ← border-b border-gray-200                                  │
└─────────────────────────────────────────────────────────────┘
```

### Table Header
```
┌──────┬──────────┬──────┬────────┬──────┬──────┬──────┬──────┬────┐
│ No   │ Nama     │ NIS  │ Pertem │ Hadir│ Sakit│ Izin │ Alpa │ %  │
│      │ Siswa    │      │uan    │      │      │      │      │    │
├──────┼──────────┼──────┼────────┼──────┼──────┼──────┼──────┼────┤
│ BG:  │ Header:  │      │        │      │      │      │      │    │
│ gray-│ gray-800 │      │        │      │      │      │      │    │
│ 374  │ white bg │      │        │      │      │      │      │    │
│ 151  │          │      │        │      │      │      │      │    │
└──────┴──────────┴──────┴────────┴──────┴──────┴──────┴──────┴────┘
```

### Table Body Rows
```
Row EVEN (Even numbered rows)
├─ BG: gray-50 / f9fafb
├─ Text: gray-900
├─ Hover: gray-100 / f3f4f6
└─ Transition: smooth

Row ODD (Odd numbered rows)
├─ BG: white / ffffff
├─ Text: gray-900
├─ Hover: gray-50 / f9fafb
└─ Transition: smooth

Status Badges
├─ Hadir ≥90%: bg-green-600, text-white
├─ Hadir 75-90%: bg-amber-600, text-white
└─ Hadir <75%: bg-red-600, text-white
```

---

## 🖱️ Interactive Elements

### Button States
```
NORMAL STATE
├─ bg-blue-600
├─ text-white
├─ cursor-pointer
├─ transition-all
└─ No shadow

HOVER STATE
├─ bg-blue-700 (darker)
├─ Slight lift effect
└─ shadow-md

ACTIVE/DISABLED STATE
├─ opacity-50
├─ cursor-not-allowed
└─ No hover effects
```

### Input Fields
```
NORMAL STATE
├─ border-gray-300
├─ bg-white
├─ text-gray-900
└─ outline-none

FOCUS STATE
├─ ring-2 ring-[color]-500
├─ border-transparent
└─ Glow effect

FILLED STATE
├─ border-[color]-300
├─ bg-[color]-50
└─ Show date value
```

---

## 🎬 Animation Timeline

### Page Load Sequence
```
0ms   - Page starts loading
       ↓
500ms - RekapController renders
       ↓
800ms - Blade template processes
       ↓
1000ms - CSS animations ready
       ↓
1200ms - Fade-in animation (data)
       ↓
1500ms - Interactive ready
```

### Filter Application Sequence
```
0ms   - User clicks "Terapkan Filter"
       ↓
50ms  - Form validation
       ↓
100ms - Loading indicator shown
       ↓
500ms - URL built, redirect triggered
       ↓
800ms - Server processes new query
       ↓
1200ms - New HTML with filtered data
       ↓
1500ms - Fade-in animation
       ↓
2000ms - Fully interactive
```

---

## 📱 Mobile Optimization

### Touch Targets
```
All buttons & inputs: minimum 44x44px
Spacing: 16px between touch targets
Font size: 16px minimum (prevent zoom)
```

### Mobile-Specific Styling
```
/* Landscape mode */
@media (max-height: 600px) {
  ├─ Reduce padding
  ├─ Smaller card heights
  └─ Compact filter bar
}

/* Portrait mode */
@media (max-width: 640px) {
  ├─ Stack cards vertically
  ├─ Full-width inputs
  └─ Larger touch targets
}
```

---

## ♿ Accessibility Features

### Semantic HTML
```
<label for="periode"> ← Connected to input
<input type="radio"> ← Proper input type
<button type="button"> ← Semantic button
<table> ← Proper table structure
```

### Color Accessibility
```
✓ All text has sufficient contrast (WCAG AA)
✓ Color not only used for distinction
✓ Icons always accompanied by text
✓ Status indicators have text labels
```

### Keyboard Navigation
```
✓ Tab through all interactive elements
✓ Enter to activate buttons
✓ Space to toggle radio buttons
✓ Escape to close modals (if any)
✓ Ctrl+P for print (browser standard)
```

---

## 🎯 Summary

Fitur Periode Filtering dirancang dengan:
- ✅ Beautiful UI dengan color coding
- ✅ Responsive design untuk semua devices
- ✅ Smooth animations & transitions
- ✅ Comprehensive error handling
- ✅ Accessibility standards
- ✅ Performance optimization

Hasilnya: **Sistem yang powerful, user-friendly, dan production-ready!** 🚀
