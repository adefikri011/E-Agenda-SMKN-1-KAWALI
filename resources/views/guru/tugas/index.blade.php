@extends('layout.main')

@section('title', 'Penginputan Nilai')

@section('content')

    <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-2xl font-semibold">Halaman Tugas Dipindahkan</h2>
        <p class="mt-4 text-sm text-gray-600">Fitur pengisian nilai sekarang ada di halaman Nilai. Anda akan diarahkan...</p>
    </div>

    <script>
        window.location.href = "{{ route('nilai.create') }}";
    </script>

@endsection
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
