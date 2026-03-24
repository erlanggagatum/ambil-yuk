@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-sm text-gray-500 mt-0.5">Ringkasan aktivitas Ambil Yuk</p>
</div>

{{-- Summary cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-sm text-gray-500 mb-1">Total Barang</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalItems }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-sm text-gray-500 mb-1">Barang Aktif</p>
        <p class="text-3xl font-bold text-indigo-600">{{ $activeItems }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-sm text-gray-500 mb-1">Booking Pending</p>
        <p class="text-3xl font-bold text-yellow-500">{{ $pendingCount }}</p>
    </div>
</div>

{{-- Quick links --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <a href="{{ route('admin.items.index') }}"
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow group">
        <div>
            <p class="font-semibold text-gray-800">Kelola Barang</p>
            <p class="text-sm text-gray-400 mt-0.5">Tambah, lihat, dan tutup barang</p>
        </div>
        <span class="text-gray-300 group-hover:text-indigo-400 text-xl transition-colors">→</span>
    </a>
    <a href="{{ route('admin.items.index') }}?pending=1"
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow group">
        <div>
            <p class="font-semibold text-gray-800">Antrian Booking</p>
            <p class="text-sm text-gray-400 mt-0.5">Konfirmasi atau tolak booking</p>
        </div>
        <span class="text-gray-300 group-hover:text-indigo-400 text-xl transition-colors">→</span>
    </a>
</div>
@endsection
