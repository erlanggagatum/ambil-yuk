@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold text-gray-800 mb-4">Barang Tersedia</h2>

@if ($activeItems->isEmpty())
    <div class="text-center py-16 text-gray-400">
        <p class="text-lg">Belum ada barang tersedia.</p>
    </div>
@else
    <div class="space-y-4">
        @foreach ($activeItems as $item)
            @php
                $remaining = $item->stock - $item->confirmed_count;
                $userBooking = $userBookings->get($item->id);
            @endphp
            <a href="{{ route('items.show', $item) }}" class="block">
                <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    {{-- Photo (first only on listing) --}}
                    @if ($item->photos->isNotEmpty())
                        <img src="{{ Storage::url($item->photos->first()->path) }}" alt="{{ $item->title }}"
                            class="w-full h-48 object-cover" />
                        @if ($item->photos->count() > 1)
                            <span class="absolute top-2 right-2 bg-black/40 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $item->photos->count() }} foto
                            </span>
                        @endif
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center">
                            <span class="text-4xl">📦</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-semibold text-gray-800 text-base leading-snug">{{ $item->title }}</h3>
                            {{-- Status badge --}}
                            <span class="shrink-0 text-xs font-medium px-2 py-0.5 rounded-full
                                {{ $remaining > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $remaining > 0 ? 'Stok: ' . $remaining : 'Habis' }}
                            </span>
                        </div>

                        {{-- Price --}}
                        <p class="text-sm font-semibold {{ $item->harga ? 'text-indigo-600' : 'text-green-600' }} mt-0.5">
                            {{ $item->harga ? '₩' . number_format($item->harga, 0, '.', ',') : 'Gratis' }}
                        </p>

                        @if ($item->description)
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                        @endif

                        {{-- Queue count --}}
                        @if ($item->pending_count > 0)
                            <span class="mt-1 inline-block text-xs text-blue-500 font-medium">{{ $item->pending_count }} orang antri</span>
                        @endif

                        {{-- User booking state --}}
                        @if ($userBooking)
                            <div class="mt-3 flex items-center gap-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full
                                    {{ $userBooking->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                       ($userBooking->status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $userBooking->status === 'confirmed' ? 'Dikonfirmasi' :
                                       ($userBooking->status === 'rejected' ? 'Ditolak' : 'Pending') }}
                                </span>
                                <span class="text-xs text-gray-400">Antrian #{{ $userBooking->queue_position }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif

{{-- Closed / Done items --}}
@unless ($closedItems->isEmpty())
    <h2 class="text-xl font-bold text-gray-800 mt-10 mb-4">Sudah Tutup</h2>
    <div class="space-y-4">
        @foreach ($closedItems as $item)
            @php $userBooking = $userBookings->get($item->id); @endphp
            <a href="{{ route('items.show', $item) }}" class="block opacity-60">
                <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Photo --}}
                    @if ($item->photos->isNotEmpty())
                        <img src="{{ Storage::url($item->photos->first()->path) }}" alt="{{ $item->title }}"
                            class="w-full h-48 object-cover grayscale" />
                        @if ($item->photos->count() > 1)
                            <span class="absolute top-2 right-2 bg-black/40 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $item->photos->count() }} foto
                            </span>
                        @endif
                    @else
                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                            <span class="text-4xl grayscale">📦</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-semibold text-gray-500 text-base leading-snug">{{ $item->title }}</h3>
                            <span class="shrink-0 text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-400">
                                {{ $item->status === 'done' ? 'Selesai' : 'Tutup' }}
                            </span>
                        </div>

                        {{-- Price --}}
                        <p class="text-sm font-semibold text-gray-400 mt-0.5">
                            {{ $item->harga ? '₩' . number_format($item->harga, 0, '.', ',') : 'Gratis' }}
                        </p>

                        @if ($item->description)
                            <p class="text-sm text-gray-400 mt-1 line-clamp-2">{{ $item->description }}</p>
                        @endif

                        {{-- Confirmed count for closed items --}}
                        @if ($item->confirmed_count > 0)
                            <span class="mt-1 inline-block text-xs text-gray-400 font-medium">{{ $item->confirmed_count }} dikonfirmasi</span>
                        @endif

                        {{-- User booking state --}}
                        @if ($userBooking)
                            <div class="mt-3 flex items-center gap-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full
                                    {{ $userBooking->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                       ($userBooking->status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $userBooking->status === 'confirmed' ? 'Dikonfirmasi' :
                                       ($userBooking->status === 'rejected' ? 'Ditolak' : 'Pending') }}
                                </span>
                                <span class="text-xs text-gray-400">Antrian #{{ $userBooking->queue_position }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endunless
@endsection
