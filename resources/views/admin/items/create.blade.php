@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.items.index') }}" class="text-sm text-indigo-600 hover:underline">← Kembali ke Barang</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Barang</h1>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-xl">
    <form method="POST" action="{{ route('admin.items.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Barang <span class="text-red-500">*</span></label>
            <input id="title" name="title" type="text" required value="{{ old('title') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('title') border-red-400 @enderror" />
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea id="description" name="description" rows="4"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
            <input id="stock" name="stock" type="number" min="1" required value="{{ old('stock', 1) }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('stock') border-red-400 @enderror" />
            @error('stock')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga (₩)</label>
            <input id="harga" name="harga" type="number" min="0" value="{{ old('harga') }}" placeholder="Kosongkan jika gratis"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('harga') border-red-400 @enderror" />
            <p class="text-xs text-gray-400 mt-1">Kosongkan jika barang ini gratis / give-away.</p>
            @error('harga')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="photos" class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
            <input id="photos" name="photos[]" type="file" accept="image/*" multiple
                class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('photos') border border-red-400 rounded-lg @enderror" />
            <p class="text-xs text-gray-400 mt-1">Bisa pilih beberapa foto sekaligus. Maks. 2MB per foto. Format: JPG, PNG, WEBP.</p>
            @error('photos')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('photos.*')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-xl text-sm transition-colors">
                Simpan Barang
            </button>
            <a href="{{ route('admin.items.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700">Batal</a>
        </div>
    </form>
</div>
@endsection
