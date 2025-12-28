<?php

/**
 * Get the color scheme for a user role
 * Returns an array with 'bg' and 'text' color classes
 */
if (!function_exists('getRoleColor')) {
    function getRoleColor($role)
    {
        $colors = [
            'admin' => [
                'bg' => '#dc2626',
                'text' => '#ffffff',
            ],
            'guru' => [
                'bg' => '#2563eb',
                'text' => '#ffffff',
            ],
            'walikelas' => [
                'bg' => '#7c3aed',
                'text' => '#ffffff',
            ],
            'sekretaris' => [
                'bg' => '#059669',
                'text' => '#ffffff',
            ],
            'siswa' => [
                'bg' => '#f59e0b',
                'text' => '#ffffff',
            ],
        ];

        return $colors[$role] ?? [
            'bg' => '#6b7280',
            'text' => '#ffffff',
        ];
    }
}

/**
 * Format password requirements message
 */
if (!function_exists('getPasswordRequirements')) {
    function getPasswordRequirements()
    {
        return [
            'min:8' => 'Minimal 8 karakter',
            'uppercase' => 'Huruf besar dan kecil',
            'number' => 'Mengandung angka (0-9)',
            'symbol' => 'Simbol (!@#$%^&*)',
        ];
    }
}

/**
 * Get role display name in Indonesian
 */
if (!function_exists('getRoleDisplayName')) {
    function getRoleDisplayName($role)
    {
        $names = [
            'admin' => 'Administrator',
            'guru' => 'Guru',
            'walikelas' => 'Wali Kelas',
            'sekretaris' => 'Sekretaris',
            'siswa' => 'Siswa',
        ];

        return $names[$role] ?? ucfirst($role);
    }
}
