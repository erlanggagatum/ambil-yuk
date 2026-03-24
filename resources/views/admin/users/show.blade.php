@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-600 hover:underline">← Kembali ke Pengguna</a>
</div>

{{-- User card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-xl font-bold text-gray-800">{{ $user->nickname }}</h1>
            <p class="text-sm text-gray-400">{{ $user->username }}</p>
        </div>

        {{-- Phone unlock --}}
        <div x-data="{
                revealed: false,
                unlocking: false,
                password: '',
                phone: '',
                error: '',
                async reveal() {
                    this.error = '';
                    const res = await fetch('{{ route('admin.users.reveal-phone', $user) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ password: this.password })
                    });
                    const data = await res.json();
                    if (data.phone) {
                        this.phone = data.phone;
                        this.revealed = true;
                        this.unlocking = false;
                        this.password = '';
                    } else {
                        this.error = data.error ?? 'Password salah.';
                    }
                }
            }">

            {{-- Revealed: call button --}}
            <a x-show="revealed" :href="'tel:' + phone"
                class="flex items-center gap-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium text-sm px-4 py-2 rounded-xl transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                </svg>
                <span x-text="phone"></span>
            </a>

            {{-- Masked --}}
            <div x-show="!revealed">
                <div x-show="!unlocking">
                    <button @click="unlocking = true"
                        class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-500 font-medium text-sm px-4 py-2 rounded-xl transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                        </svg>
                        <span class="tracking-widest">••••••••••</span>
                        <span class="text-xs font-normal text-gray-400">Buka</span>
                    </button>
                </div>

                {{-- Password prompt --}}
                <div x-show="unlocking" class="flex items-center gap-2 flex-wrap">
                    <input type="password" x-model="password" placeholder="Masukkan password"
                        @keydown.enter="reveal()" @keydown.escape="unlocking = false; password = ''; error = ''"
                        x-ref="pwdinput" x-init="$watch('unlocking', v => v && $nextTick(() => $refs.pwdinput.focus()))"
                        class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 w-44" />
                    <button @click="reveal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors">
                        Buka
                    </button>
                    <button @click="unlocking = false; password = ''; error = ''"
                        class="text-sm text-gray-400 hover:text-gray-600">Batal</button>
                </div>
                <p x-show="error" x-text="error" class="text-xs text-red-500 mt-1.5"></p>
            </div>
        </div>
    </div>
</div>

{{-- Bookings --}}
<h2 class="text-lg font-semibold text-gray-800 mb-3">
    Riwayat Booking
    <span class="text-sm font-normal text-gray-400 ml-1">({{ $bookings->count() }} booking)</span>
</h2>

@if ($bookings->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-400 text-sm">
        Pengguna ini belum memiliki booking.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-gray-500 font-medium">Barang</th>
                    <th class="text-center px-4 py-3 text-gray-500 font-medium hidden sm:table-cell">Antrian</th>
                    <th class="text-center px-4 py-3 text-gray-500 font-medium">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $booking->item->title }}</div>
                            <div class="text-xs text-gray-400">
                                {{ $booking->item->harga ? '₩' . number_format($booking->item->harga, 0, '.', ',') : 'Gratis' }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-500 hidden sm:table-cell">
                            #{{ $booking->queue_position }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @include('admin.partials.booking-status-badge', ['status' => $booking->status])
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.items.show', $booking->item) }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">
                                Lihat →
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
