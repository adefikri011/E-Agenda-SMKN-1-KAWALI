@extends('layout.main')

@section('content')
<div class="min-h-screen bg-gray-50">
    <style>
        .status-selector, .status-option, .relative[x-data] > [x-show] { display: none !important; }
    </style>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">na
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Presensi Siswa</h1>
                    <p class="mt-2 text-sm text-gray-600">Input kehadiran siswa untuk pertemuan saat ini</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $tanggal }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pertemuan -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Detail Pertemuan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500 mb-1">Mata Pelajaran</div>
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-blue-500 mr-3"></div>
                                    <span class="text-lg font-semibold text-gray-900">{{ $mapel->nama_mapel }}</span>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500 mb-1">Kelas</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $kelas->nama_kelas }}</div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500 mb-1">Waktu</div>
                                <div class="flex items-center text-lg font-semibold text-gray-900">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $jam }}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500 mb-1">Pertemuan</div>
                                <div class="text-lg font-semibold text-gray-900">Ke-{{ $pertemuan }}</div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500 mb-1">Total Siswa</div>
                                <div class="flex items-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ count($siswa) }}</div>
                                    <div class="ml-2 text-sm text-gray-500">orang</div>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500 mb-1">Status</div>
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Menunggu Input
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Absensi -->
        <form action="{{ route('absensi.store') }}" method="POST" id="absensiForm">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
            <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="jam" value="{{ $jam }}">
            <input type="hidden" name="pertemuan" value="{{ $pertemuan }}">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Siswa</h2>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Tips:</span> Klik pada status untuk mengubahnya
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto max-h-80 overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($siswa as $index => $s)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 font-medium">{{ $index + 1 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $s->nis }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                            <span class="text-gray-700 font-medium">{{ substr($s->nama_siswa, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $s->nama_siswa }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $s->id }}">
                                    <div class="relative" x-data="{ open: false, selectedStatus: null }">
                                        <button type="button"
                                                @click="open = !open"
                                                :class="{
                                                    'bg-green-100 text-green-800 border-green-200': selectedStatus === 'hadir',
                                                    'bg-yellow-100 text-yellow-800 border-yellow-200': selectedStatus === 'izin',
                                                    'bg-purple-100 text-purple-800 border-purple-200': selectedStatus === 'sakit',
                                                    'bg-red-100 text-red-800 border-red-200': selectedStatus === 'alpha',
                                                    'bg-gray-100 text-gray-800 border-gray-200': !selectedStatus
                                                }"
                                                class="status-selector w-full px-4 py-2 text-left rounded-lg border focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 transition-all duration-200 flex items-center justify-between"
                                                data-status="hadir"
                                                data-index="{{ $index }}">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Hadir
                                            </span>
                                            <svg class="w-5 h-5 ml-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>

                                        <div x-show="open"
                                             @click.away="open = false"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute z-10 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                                                <button type="button"
                                                    onclick="handleStatusOptionClick(this)"
                                                    class="status-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center transition-colors duration-150"
                                                    data-value="hadir"
                                                    data-index="{{ $index }}">
                                                <svg class="w-4 h-4 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-900">Hadir</span>
                                            </button>
                                                <button type="button"
                                                    onclick="handleStatusOptionClick(this)"
                                                    class="status-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center transition-colors duration-150"
                                                    data-value="izin"
                                                    data-index="{{ $index }}">
                                                <svg class="w-4 h-4 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-900">Izin</span>
                                            </button>
                                                <button type="button"
                                                    onclick="handleStatusOptionClick(this)"
                                                    class="status-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center transition-colors duration-150"
                                                    data-value="sakit"
                                                    data-index="{{ $index }}">
                                                <svg class="w-4 h-4 mr-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                                </svg>
                                                <span class="text-gray-900">Sakit</span>
                                            </button>
                                                <button type="button"
                                                    onclick="handleStatusOptionClick(this)"
                                                    class="status-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center transition-colors duration-150"
                                                    data-value="alpha"
                                                    data-index="{{ $index }}">
                                                <svg class="w-4 h-4 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-900">Alpha</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Hidden input for form submission -->
                                    <select name="absensi[{{ $index }}][status]" class="hidden-status-select w-full px-4 py-2 rounded-lg border text-sm" data-index="{{ $index }}">
                                        <option value="hadir">Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="alpha">Alpha</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Total:</span> {{ count($siswa) }} siswa
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('absensi.index') }}"
                               class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg text-sm font-medium text-white hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Simpan Absensi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Alpine.js for dropdowns
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            open: false,
            toggle() {
                this.open = !this.open
            }
        }))
    });

    // Status options with colors and icons
    const statusOptions = {
        hadir: {
            label: 'Hadir',
            bgColor: 'bg-green-100',
            textColor: 'text-green-800',
            borderColor: 'border-green-200',
            icon: `<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>`
        },
        izin: {
            label: 'Izin',
            bgColor: 'bg-yellow-100',
            textColor: 'text-yellow-800',
            borderColor: 'border-yellow-200',
            icon: `<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>`
        },
        sakit: {
            label: 'Sakit',
            bgColor: 'bg-purple-100',
            textColor: 'text-purple-800',
            borderColor: 'border-purple-200',
            icon: `<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>`
        },
        alpha: {
            label: 'Alpha',
            bgColor: 'bg-red-100',
            textColor: 'text-red-800',
            borderColor: 'border-red-200',
            icon: `<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>`
        }
    };

    // Initialize status selectors
    function initializeStatusSelectors() {
        document.querySelectorAll('.status-selector').forEach(selector => {
            const index = selector.getAttribute('data-index');
            const hiddenSelect = document.querySelector(`.hidden-status-select[data-index="${index}"]`);

            // Set initial value
            if (hiddenSelect) {
                const value = hiddenSelect.value;
                updateSelectorAppearance(selector, value);
            }

            // Handle option clicks
            document.querySelectorAll(`.status-option[data-index="${index}"]`).forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');

                    // Update hidden select
                    if (hiddenSelect) {
                        hiddenSelect.value = value;
                    }

                    // Update selector appearance
                    updateSelectorAppearance(selector, value);

                    // Close dropdown (Alpine.js)
                    const dropdown = selector.closest('[x-data]');
                    if (dropdown && dropdown.__x) {
                        dropdown.__x.$data.open = false;
                    }

                    // Update statistics
                    updateStatistics();
                });
            });
        });

        // Update statistics on load
        updateStatistics();
    }

    function updateSelectorAppearance(selector, status) {
        const config = statusOptions[status];
        if (!config) return;

        selector.innerHTML = `
            <span class="flex items-center">
                ${config.icon}
                ${config.label}
            </span>
            <svg class="w-5 h-5 ml-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        `;

        // Update classes
        selector.className = selector.className.replace(/bg-\w+-\d+/g, '');
        selector.className = selector.className.replace(/text-\w+-\d+/g, '');
        selector.className = selector.className.replace(/border-\w+-\d+/g, '');

        selector.classList.add(config.bgColor, config.textColor, config.borderColor);
    }

    function updateStatistics() {
        const counts = {
            hadir: 0,
            izin: 0,
            sakit: 0,
            alpha: 0
        };

        // Count statuses
        document.querySelectorAll('.hidden-status-select').forEach(select => {
            counts[select.value]++;
        });

        // Update display
        Object.keys(counts).forEach(status => {
            const element = document.getElementById(`${status}-count`);
            if (element) {
                element.textContent = counts[status];
            }
        });
    }

    // Form submission
    const form = document.getElementById('absensiForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validation: Check if all statuses are set
            let allSet = true;
            const selects = this.querySelectorAll('.hidden-status-select');

            selects.forEach(select => {
                if (!select.value) {
                    allSet = false;
                }
            });

            if (!allSet) {
                e.preventDefault();
                alert('Mohon atur status kehadiran untuk semua siswa sebelum menyimpan.');
                return false;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                `;
                submitBtn.disabled = true;
            }
        });
    }

    // Initialize on DOM ready (run immediately if already loaded)
    if (document.readyState !== 'loading') {
        initializeStatusSelectors();
    } else {
        document.addEventListener('DOMContentLoaded', initializeStatusSelectors);
    }

    // Delegate clicks on status options to ensure handlers work even if elements are rendered later
    document.addEventListener('click', function(e) {
        const opt = e.target.closest('.status-option');
        if (!opt) return;
        const index = opt.getAttribute('data-index');
        const value = opt.getAttribute('data-value');
        const hiddenSelect = document.querySelector(`.hidden-status-select[data-index="${index}"]`);
        const selector = document.querySelector(`.status-selector[data-index="${index}"]`);
        if (hiddenSelect) hiddenSelect.value = value;
        if (selector) {
            updateSelectorAppearance(selector, value);
        }
        // close Alpine dropdown if present
        const dropdown = selector ? selector.closest('[x-data]') : null;
        if (dropdown && dropdown.__x) {
            try {
                dropdown.__x.$data.open = false;
                dropdown.__x.$data.selectedStatus = value;
            } catch (err) {}
        }
    });

    // Inline handler used by status-option buttons (fallback for delegation)
    function handleStatusOptionClick(el) {
        const index = el.getAttribute('data-index');
        const value = el.getAttribute('data-value');
        const hiddenSelect = document.querySelector(`.hidden-status-select[data-index="${index}"]`);
        const selector = document.querySelector(`.status-selector[data-index="${index}"]`);
        if (hiddenSelect) hiddenSelect.value = value;
        if (selector) updateSelectorAppearance(selector, value);
        const dropdown = selector ? selector.closest('[x-data]') : null;
        if (dropdown && dropdown.__x) {
            try {
                dropdown.__x.$data.open = false;
                dropdown.__x.$data.selectedStatus = value;
            } catch (err) {}
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            document.getElementById('absensiForm').querySelector('button[type="submit"]').click();
        }

        // Escape to close dropdowns
        if (e.key === 'Escape') {
            document.querySelectorAll('[x-data]').forEach(dropdown => {
                if (dropdown.__x && dropdown.__x.$data.open) {
                    dropdown.__x.$data.open = false;
                }
            });
        }
    });
});
</script>
@endpush
@endsection
