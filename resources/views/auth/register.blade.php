@extends('layouts.guest')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Daftar Akun</h2>

    <form method="POST" action="/register" class="space-y-4">
        @csrf

        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input id="username" name="username" type="text" autocomplete="username" required
                value="{{ old('username') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('username') border-red-400 @enderror" />
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nickname" class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan</label>
            <input id="nickname" name="nickname" type="text" required
                value="{{ old('nickname') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('nickname') border-red-400 @enderror" />
            @error('nickname')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
            <input id="phone_number" name="phone_number" type="tel" required
                value="{{ old('phone_number') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('phone_number') border-red-400 @enderror" />
            @error('phone_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('password') border-red-400 @enderror" />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent" />
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg py-2 text-sm transition-colors">
            Daftar
        </button>
    </form>
</div>

<p class="text-center text-sm text-gray-500 mt-4">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">Masuk</a>
</p>
@endsection
