<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount('bookings')->orderByDesc('created_at')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $prodis = Prodi::where('is_active', true)->orderBy('jurusan')->orderBy('name')->get();
        return view('admin.rooms.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:rooms,code',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'facilities' => 'nullable|string',
            'is_active' => 'boolean',
            'allowed_prodis' => 'nullable|array',
            'allowed_prodis.*' => 'exists:prodis,id',
        ]);

        if (!empty($validated['facilities'])) {
            $validated['facilities'] = array_map('trim', explode(',', $validated['facilities']));
        } else {
            $validated['facilities'] = [];
        }

        $validated['is_active'] = $request->boolean('is_active');

        $allowedProdis = $validated['allowed_prodis'] ?? [];
        unset($validated['allowed_prodis']);

        $room = Room::create($validated);
        $room->allowedProdis()->sync($allowedProdis);

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $prodis = Prodi::where('is_active', true)->orderBy('jurusan')->orderBy('name')->get();
        $room->load('allowedProdis');
        return view('admin.rooms.edit', compact('room', 'prodis'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:rooms,code,' . $room->id,
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'facilities' => 'nullable|string',
            'is_active' => 'boolean',
            'allowed_prodis' => 'nullable|array',
            'allowed_prodis.*' => 'exists:prodis,id',
        ]);

        if (!empty($validated['facilities'])) {
            $validated['facilities'] = array_map('trim', explode(',', $validated['facilities']));
        } else {
            $validated['facilities'] = [];
        }

        $validated['is_active'] = $request->boolean('is_active');

        $allowedProdis = $validated['allowed_prodis'] ?? [];
        unset($validated['allowed_prodis']);

        $room->update($validated);
        $room->allowedProdis()->sync($allowedProdis);

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }

    public function toggle(Room $room)
    {
        $room->update(['is_active' => !$room->is_active]);
        $status = $room->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.rooms.index')->with('success', "Ruangan berhasil {$status}.");
    }
}
