@php
    $map = [
        'pending'   => ['bg-yellow-100 text-yellow-700', 'Pending'],
        'confirmed' => ['bg-green-100 text-green-700',   'Dikonfirmasi'],
        'rejected'  => ['bg-red-100 text-red-500',       'Ditolak'],
    ];
    [$cls, $label] = $map[$status] ?? ['bg-gray-100 text-gray-400', ucfirst($status)];
@endphp
<span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full {{ $cls }}">{{ $label }}</span>
