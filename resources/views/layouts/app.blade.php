<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-2xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ route('items.index') }}" class="text-lg font-bold text-indigo-600 tracking-tight">
                    {{ config('app.name') }}
                </a>
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('items.index') }}"
                        class="transition-colors {{ request()->routeIs('items.*') ? 'text-indigo-600 font-medium' : 'text-gray-500 hover:text-gray-800' }}">
                        Barang
                    </a>
                    <a href="{{ route('bookings.index') }}"
                        class="transition-colors {{ request()->routeIs('bookings.index') ? 'text-indigo-600 font-medium' : 'text-gray-500 hover:text-gray-800' }}">
                        Booking Saya
                    </a>
                </div>
            </div>
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open"
                    class="flex items-center gap-2 rounded-full px-2 py-1 transition-colors
                        {{ request()->routeIs('profile.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm-7 8a7 7 0 0 1 14 0H5Z" clip-rule="evenodd" />
                    </svg>
                    <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->nickname }}</span>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-20"
                    style="display: none;">
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->nickname }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::user()->username }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        Edit Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    <div class="max-w-2xl mx-auto px-4 mt-4 space-y-2">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Page content --}}
    <main class="max-w-2xl mx-auto px-4 py-6">
        @yield('content')
    </main>

</body>
</html>
