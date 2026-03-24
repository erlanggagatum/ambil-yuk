@extends('layouts.app')

@section('content')
{{-- Back link --}}
<a href="{{ route('items.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:underline mb-4">
    ← Semua Barang
</a>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Photo carousel --}}
    @include('partials.photo-stack', ['photos' => $item->photos])

    <div class="p-5">
        {{-- Title & status --}}
        <div class="flex items-start justify-between gap-2 mb-1">
            <h1 class="text-xl font-bold text-gray-800 leading-snug">{{ $item->title }}</h1>
            @php $remaining = $item->stock - $confirmedCount; @endphp
            <span class="shrink-0 text-xs font-semibold px-2 py-0.5 rounded-full mt-1
                {{ $item->status === 'active' && $remaining > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $item->status === 'active' ? ($remaining > 0 ? 'Aktif' : 'Stok Habis') : ucfirst($item->status) }}
            </span>
        </div>

        <p class="text-sm text-gray-500 mb-1">Stok tersisa: <span class="font-medium text-gray-700">{{ $remaining }}</span></p>
        <p class="text-base font-bold {{ $item->harga ? 'text-indigo-600' : 'text-green-600' }}">
            {{ $item->harga ? '₩' . number_format($item->harga, 0, '.', ',') : 'Gratis' }}
        </p>

        @if ($item->description)
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $item->description }}</p>
        @endif

        {{-- Book / status section --}}
        <div class="mt-5">
            @if ($userBooking)
                <div class="rounded-xl border p-4
                    {{ $userBooking->status === 'confirmed' ? 'border-green-200 bg-green-50' :
                       ($userBooking->status === 'rejected' ? 'border-red-200 bg-red-50' : 'border-yellow-200 bg-yellow-50') }}">
                    <p class="text-sm font-semibold
                        {{ $userBooking->status === 'confirmed' ? 'text-green-700' :
                           ($userBooking->status === 'rejected' ? 'text-red-600' : 'text-yellow-700') }}">
                        @if ($userBooking->status === 'confirmed')
                            ✅ Booking kamu dikonfirmasi!
                        @elseif ($userBooking->status === 'rejected')
                            ❌ Booking kamu ditolak.
                        @else
                            ⏳ Booking kamu sedang menunggu konfirmasi.
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Nomor antrian: <strong>#{{ $userBooking->queue_position }}</strong></p>
                </div>
            @elseif ($item->status === 'active' && $remaining > 0)
                <form method="POST" action="{{ route('items.book', $item) }}"
                    x-data
                    @submit.prevent="if(confirm('Konfirmasi booking item ini?')) $el.submit()">
                    @csrf
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl py-3 text-sm transition-colors">
                        Book Sekarang
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-400 text-center py-2">Tidak dapat melakukan booking saat ini.</p>
            @endif
        </div>
    </div>
</div>

{{-- Queue list --}}
@if ($queue->isNotEmpty())
    <div class="mt-6">
        <h2 class="text-base font-semibold text-gray-700 mb-3">Daftar Antrian ({{ $queue->count() }})</h2>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100">
            @foreach ($queue as $booking)
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-gray-400 w-6 text-center">#{{ $booking->queue_position }}</span>
                        <span class="text-sm font-medium text-gray-700">{{ $booking->user->nickname }}</span>
                        @if ($booking->user_id === Auth::id())
                            <span class="text-xs bg-indigo-100 text-indigo-600 px-1.5 py-0.5 rounded-full">Kamu</span>
                        @endif
                    </div>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full
                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                           ($booking->status === 'rejected' ? 'bg-red-100 text-red-500' : 'bg-yellow-100 text-yellow-600') }}">
                        {{ $booking->status === 'confirmed' ? 'Dikonfirmasi' :
                           ($booking->status === 'rejected' ? 'Ditolak' : 'Pending') }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
