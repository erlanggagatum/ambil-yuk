<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminItemController extends Controller
{
    public function index()
    {
        $items = Item::withCount('bookings')->latest()->get();

        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'stock'        => ['required', 'integer', 'min:1'],
            'harga'        => ['nullable', 'integer', 'min:0'],
            'photos'       => ['nullable', 'array', 'max:10'],
            'photos.*'     => ['image', 'max:2048'],
        ]);

        $item = Item::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'stock'       => $validated['stock'],
            'harga'       => $validated['harga'] ?? null,
            'status'      => 'active',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                $path = $file->store('items', 'public');
                ItemPhoto::create([
                    'item_id' => $item->id,
                    'path'    => $path,
                    'order'   => $index,
                ]);
            }
        }

        return redirect()->route('admin.items.index')
            ->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $item->load('photos');
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'stock'           => ['required', 'integer', 'min:1'],
            'harga'           => ['nullable', 'integer', 'min:0'],
            'photos'          => ['nullable', 'array', 'max:10'],
            'photos.*'        => ['image', 'max:2048'],
            'remove_photos'   => ['nullable', 'array'],
            'remove_photos.*' => ['integer', 'exists:item_photos,id'],
        ]);

        $item->update([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'stock'       => $validated['stock'],
            'harga'       => $validated['harga'] ?? null,
        ]);

        if (!empty($validated['remove_photos'])) {
            $toDelete = ItemPhoto::whereIn('id', $validated['remove_photos'])
                ->where('item_id', $item->id)
                ->get();
            foreach ($toDelete as $photo) {
                Storage::disk('public')->delete($photo->path);
                $photo->delete();
            }
        }

        if ($request->hasFile('photos')) {
            $nextOrder = ($item->photos()->max('order') ?? -1) + 1;
            foreach ($request->file('photos') as $index => $file) {
                $path = $file->store('items', 'public');
                ItemPhoto::create([
                    'item_id' => $item->id,
                    'path'    => $path,
                    'order'   => $nextOrder + $index,
                ]);
            }
        }

        return redirect()->route('admin.items.show', $item)
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function show(Item $item)
    {
        $item->load('photos');

        $queue = $item->bookings()
            ->with('user')
            ->orderBy('queue_position')
            ->get();

        return view('admin.items.show', compact('item', 'queue'));
    }

    public function close(Item $item)
    {
        $item->update(['status' => 'done']);

        return back()->with('success', 'Item telah ditutup.');
    }
}
