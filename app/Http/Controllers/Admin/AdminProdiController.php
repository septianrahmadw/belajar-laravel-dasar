<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class AdminProdiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prodi::query();

        if ($jurusan = $request->get('jurusan')) {
            $query->where('jurusan', $jurusan);
        }

        $prodis = $query->orderBy('jurusan')->orderBy('name')->get();

        $jurusans = [
            'Budidaya Tanaman Pangan',
            'Budidaya Tanaman Perkebunan',
            'Teknologi Pertanian',
            'Peternakan',
            'Ekonomi dan Bisnis',
            'Teknik',
            'Perikanan dan Kelautan',
            'Teknologi Informasi',
        ];

        return view('admin.prodis.index', compact('prodis', 'jurusans'));
    }

    public function create()
    {
        $jurusans = [
            'Budidaya Tanaman Pangan',
            'Budidaya Tanaman Perkebunan',
            'Teknologi Pertanian',
            'Peternakan',
            'Ekonomi dan Bisnis',
            'Teknik',
            'Perikanan dan Kelautan',
            'Teknologi Informasi',
        ];

        return view('admin.prodis.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Prodi::create($validated);

        return redirect()->route('admin.prodis.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi)
    {
        $jurusans = [
            'Budidaya Tanaman Pangan',
            'Budidaya Tanaman Perkebunan',
            'Teknologi Pertanian',
            'Peternakan',
            'Ekonomi dan Bisnis',
            'Teknik',
            'Perikanan dan Kelautan',
            'Teknologi Informasi',
        ];

        return view('admin.prodis.edit', compact('prodi', 'jurusans'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $prodi->update($validated);

        return redirect()->route('admin.prodis.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('admin.prodis.index')->with('success', 'Prodi berhasil dihapus.');
    }

    public function toggle(Prodi $prodi)
    {
        $prodi->update(['is_active' => !$prodi->is_active]);
        $status = $prodi->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.prodis.index')->with('success', "Prodi berhasil {$status}.");
    }
}
