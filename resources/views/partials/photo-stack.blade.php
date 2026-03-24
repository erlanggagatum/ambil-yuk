{{--
  Usage: @include('partials.photo-stack', ['photos' => $item->photos])
--}}
@if ($photos->isNotEmpty())
    <div class="divide-y divide-gray-100">
        @foreach ($photos as $i => $photo)
            <img src="{{ Storage::url($photo->path) }}"
                 alt="Foto {{ $i + 1 }}"
                 class="w-full h-auto block" />
        @endforeach
    </div>
@else
    <div class="w-full py-16 bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center">
        <span class="text-5xl">📦</span>
    </div>
@endif
