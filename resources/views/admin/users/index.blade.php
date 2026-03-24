@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengguna</h1>
    <p class="text-sm text-gray-500 mt-0.5">{{ $users->count() }} pengguna terdaftar</p>
</div>

@if ($users->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">
        Belum ada pengguna terdaftar.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-gray-500 font-medium">Nama</th>
                    <th class="text-left px-4 py-3 text-gray-500 font-medium">No. HP</th>
                    <th class="text-center px-4 py-3 text-gray-500 font-medium hidden sm:table-cell">Booking</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $user->nickname }}</div>
                            <div class="text-xs text-gray-400">{{ $user->username }}</div>
                        </td>

                        {{-- Phone with lock --}}
                        <td class="px-4 py-3"
                            x-data="{
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

                            {{-- Masked --}}
                            <div x-show="!revealed">
                                <div class="flex items-center gap-2">
                                    <span class="tracking-widest text-gray-400 font-medium select-none">••••••••••</span>
                                    <button x-show="!unlocking" @click="unlocking = true"
                                        class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                        Buka
                                    </button>
                                </div>

                                {{-- Inline password prompt --}}
                                <div x-show="unlocking" class="mt-1.5 flex items-center gap-1.5">
                                    <input type="password" x-model="password" placeholder="Password"
                                        @keydown.enter="reveal()" @keydown.escape="unlocking = false; password = ''; error = ''"
                                        x-ref="pwdinput" x-init="$watch('unlocking', v => v && $nextTick(() => $refs.pwdinput.focus()))"
                                        class="w-28 border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                    <button @click="reveal()"
                                        class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded-lg transition-colors">
                                        OK
                                    </button>
                                    <button @click="unlocking = false; password = ''; error = ''"
                                        class="text-xs text-gray-400 hover:text-gray-600">✕</button>
                                </div>
                                <p x-show="error" x-text="error" class="text-xs text-red-500 mt-1"></p>
                            </div>

                            {{-- Revealed --}}
                            <a x-show="revealed" :href="'tel:' + phone" x-text="phone"
                                class="text-indigo-600 hover:underline font-medium"></a>
                        </td>

                        <td class="px-4 py-3 text-center text-gray-600 hidden sm:table-cell">
                            {{ $user->bookings_count }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.users.show', $user) }}"
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
