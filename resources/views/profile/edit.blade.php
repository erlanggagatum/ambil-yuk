@extends($layout)

@section('content')
<div class="max-w-lg mx-auto">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Profil Saya</h2>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Username --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400
                    @error('username') border-red-400 @enderror" />
            @error('username')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama / Nickname --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="nickname" value="{{ old('nickname', Auth::user()->nickname) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400
                    @error('nickname') border-red-400 @enderror" />
            @error('nickname')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400
                    @error('phone_number') border-red-400 @enderror" />
            @error('phone_number')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <hr class="border-gray-200" />

        <p class="text-sm text-gray-500">Isi bagian ini hanya jika ingin mengganti password.</p>

        {{-- Current password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
            <input type="password" name="current_password" autocomplete="current-password"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400
                    @error('current_password') border-red-400 @enderror" />
            @error('current_password')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- New password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input type="password" name="new_password" autocomplete="new-password"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400
                    @error('new_password') border-red-400 @enderror" />
            @error('new_password')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm new password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" autocomplete="new-password"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-xl text-sm transition-colors">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
