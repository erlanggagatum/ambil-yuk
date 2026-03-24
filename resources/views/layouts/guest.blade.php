<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-indigo-600">{{ config('app.name') }}</h1>
            <p class="text-sm text-gray-500 mt-1">Barang Lelang & Give-away</p>
        </div>

        @yield('content')
    </div>

</body>
</html>
