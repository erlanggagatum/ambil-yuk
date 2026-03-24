@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.items.index') }}" class="text-sm text-indigo-600 hover:underline">← Kembali ke Barang</a>
    <a href="{{ route('admin.items.edit', $item) }}"
        class="text-sm bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium px-4 py-1.5 rounded-lg transition-colors">
        Edit Barang
    </a>
</div>

{{-- Item header --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    @include('partials.photo-stack', ['photos' => $item->photos])
    <div class="p-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $item->title }}</h1>
                @if ($item->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $item->description }}</p>
                @endif
            </div>
            <div class="flex flex-col items-end gap-2 shrink-0">
                @include('admin.partials.item-status-badge', ['status' => $item->status])
                <span class="text-xs text-gray-500">Stok: <strong>{{ $item->stock }}</strong></span>
                <span class="text-xs font-semibold {{ $item->harga ? 'text-indigo-600' : 'text-green-600' }}">
                    {{ $item->harga ? '₩' . number_format($item->harga, 0, '.', ',') : 'Gratis' }}
                </span>
            </div>
        </div>

        {{-- Close item button --}}
        @if ($item->status === 'active')
            <div class="mt-4 pt-4 border-t border-gray-100">
                <form method="POST" action="{{ route('admin.items.close', $item) }}"
                    x-data
                    @submit.prevent="if(confirm('Tutup item ini? Tidak ada booking baru yang bisa masuk.')) $el.submit()">
                    @csrf
                    <button type="submit"
                        class="text-sm text-red-600 hover:text-red-700 border border-red-200 hover:border-red-400 px-4 py-1.5 rounded-lg transition-colors">
                        Tutup Item
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

{{-- Booking queue --}}
<div>
    <h2 class="text-lg font-semibold text-gray-800 mb-3">
        Antrian Booking
        <span class="text-sm font-normal text-gray-400 ml-1">({{ $queue->count() }} booking)</span>
    </h2>

    @if ($queue->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-400 text-sm">
            Belum ada booking untuk item ini.
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-gray-500 font-medium w-10">#</th>
                        <th class="text-left px-4 py-3 text-gray-500 font-medium">Nama</th>
                        <th class="text-left px-4 py-3 text-gray-500 font-medium hidden sm:table-cell">No. HP</th>
                        <th class="text-center px-4 py-3 text-gray-500 font-medium">Status</th>
                        <th class="px-4 py-3 text-gray-500 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($queue as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-400 font-bold">{{ $booking->queue_position }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800">{{ $booking->user->nickname }}</div>
                                <div class="text-xs text-gray-400">{{ $booking->user->username }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-500 hidden sm:table-cell">
                                {{ $booking->user->phone_number }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @include('admin.partials.booking-status-badge', ['status' => $booking->status])
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2" x-data>
                                    @if ($booking->status === 'pending')
                                        <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}"
                                            @submit.prevent="if(confirm('Konfirmasi booking dari {{ addslashes($booking->user->nickname) }}?')) $el.submit()">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs bg-green-100 hover:bg-green-200 text-green-700 font-medium px-3 py-1 rounded-lg transition-colors">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    @endif

                                    @if (in_array($booking->status, ['pending', 'confirmed']))
                                        <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}"
                                            @submit.prevent="if(confirm('Tolak booking dari {{ addslashes($booking->user->nickname) }}?')) $el.submit()">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs bg-red-50 hover:bg-red-100 text-red-600 font-medium px-3 py-1 rounded-lg transition-colors">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif

                                    @if ($booking->status === 'rejected')
                                        <span class="text-xs text-gray-300">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
