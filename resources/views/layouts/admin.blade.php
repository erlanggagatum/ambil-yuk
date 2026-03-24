<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen" x-data>

    {{-- Top nav --}}
    <nav class="bg-indigo-700 text-white sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <span class="font-bold text-lg tracking-tight">{{ config('app.name') }} <span class="text-indigo-300 text-xs font-normal ml-1">Admin</span></span>
                <div class="hidden sm:flex items-center gap-4 text-sm">
                    <a href="{{ route('admin.dashboard') }}"
                        class="hover:text-white/80 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-white font-semibold' : 'text-indigo-200' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.items.index') }}"
                        class="hover:text-white/80 transition-colors {{ request()->routeIs('admin.items.*') ? 'text-white font-semibold' : 'text-indigo-200' }}">
                        Barang
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="hover:text-white/80 transition-colors {{ request()->routeIs('admin.users.*') ? 'text-white font-semibold' : 'text-indigo-200' }}">
                        Pengguna
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('profile.edit') }}"
                    class="text-xs hidden sm:block hover:text-white transition-colors {{ request()->routeIs('profile.*') ? 'text-white font-semibold' : 'text-indigo-300' }}">
                    {{ Auth::user()->nickname }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-xs text-indigo-200 hover:text-white border border-indigo-500 hover:border-indigo-300 px-3 py-1 rounded-lg transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
        {{-- Mobile sub-nav --}}
        <div class="sm:hidden flex items-center gap-4 px-4 pb-2 text-sm border-t border-indigo-600">
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'text-white font-semibold' : 'text-indigo-200' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.items.index') }}"
                class="{{ request()->routeIs('admin.items.*') ? 'text-white font-semibold' : 'text-indigo-200' }}">
                Barang
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="{{ request()->routeIs('admin.users.*') ? 'text-white font-semibold' : 'text-indigo-200' }}">
                Pengguna
            </a>
        </div>
    </nav>

    {{-- Flash messages --}}
    <div class="max-w-5xl mx-auto px-4 mt-4 space-y-2">
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
    <main class="max-w-5xl mx-auto px-4 py-6">
        @yield('content')
    </main>

</body>
</html>
