@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Barang</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $items->count() }} total barang</p>
    </div>
    <a href="{{ route('admin.items.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors">
        + Tambah Barang
    </a>
</div>

@if ($items->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">
        Belum ada barang. <a href="{{ route('admin.items.create') }}" class="text-indigo-600 underline">Tambah sekarang</a>.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-gray-500 font-medium">Barang</th>
                    <th class="text-center px-4 py-3 text-gray-500 font-medium hidden sm:table-cell">Stok</th>
                    <th class="text-center px-4 py-3 text-gray-500 font-medium hidden sm:table-cell">Booking</th>
                    <th class="text-center px-4 py-3 text-gray-500 font-medium">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($items as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $item->title }}</div>
                            @if ($item->description)
                                <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center hidden sm:table-cell">
                            <span class="font-semibold text-gray-700">{{ $item->stock }}</span>
                        </td>
                        <td class="px-4 py-3 text-center hidden sm:table-cell">
                            <span class="text-gray-600">{{ $item->bookings_count }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @include('admin.partials.item-status-badge', ['status' => $item->status])
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.items.edit', $item) }}"
                                    class="text-gray-500 hover:text-indigo-600 font-medium text-xs transition-colors">
                                    Edit
                                </a>
                                <a href="{{ route('admin.items.show', $item) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">
                                    Lihat →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
