@php
    $map = [
        'active' => ['bg-green-100 text-green-700', 'Aktif'],
        'closed' => ['bg-gray-100 text-gray-500', 'Ditutup'],
        'done'   => ['bg-gray-200 text-gray-500', 'Selesai'],
    ];
    [$cls, $label] = $map[$status] ?? ['bg-gray-100 text-gray-400', ucfirst($status)];
@endphp
<span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full {{ $cls }}">{{ $label }}</span>
