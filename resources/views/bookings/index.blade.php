@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold text-gray-800 mb-1">Booking Saya</h2>
<p class="text-sm text-gray-400 mb-5">{{ $bookings->count() }} item yang kamu minati</p>

@if ($bookings->isEmpty())
    <div class="text-center py-16 text-gray-400 text-sm">
        Kamu belum booking apapun.
        <a href="{{ route('items.index') }}" class="text-indigo-600 hover:underline">Lihat barang tersedia</a>.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100">
        @foreach ($bookings as $booking)
            <a href="{{ route('items.show', $booking->item) }}"
                class="flex items-center justify-between px-4 py-3.5 hover:bg-gray-50 transition-colors group">

                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate group-hover:text-indigo-600 transition-colors">
                        {{ $booking->item->title }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Antrian #{{ $booking->queue_position }}
                        &middot;
                        {{ $booking->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0 ml-4">
                    @php
                        $badge = match($booking->status) {
                            'confirmed' => ['bg-green-100 text-green-700', 'Dikonfirmasi'],
                            'rejected'  => ['bg-red-100 text-red-500',    'Ditolak'],
                            default     => ['bg-yellow-100 text-yellow-700', 'Pending'],
                        };
                    @endphp
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $badge[0] }}">
                        {{ $badge[1] }}
                    </span>
                    <span class="text-gray-300 group-hover:text-indigo-400 transition-colors text-sm">→</span>
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection
