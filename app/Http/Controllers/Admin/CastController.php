<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CastController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $casts = Cast::query()
            ->withCount('perans')
            ->when($q !== '', fn ($query) => $query->where('nama', 'like', '%'.$q.'%'))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.casts.index', compact('casts', 'q'));
    }

    public function create(): View
    {
        return view('admin.casts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Cast::create($this->validated($request));

        return redirect()->route('admin.cast.index')->with('success', 'Cast berhasil ditambahkan.');
    }

    public function show(Cast $cast): View
    {
        $cast->load('perans.film');

        return view('admin.casts.show', compact('cast'));
    }

    public function edit(Cast $cast): View
    {
        return view('admin.casts.edit', compact('cast'));
    }

    public function update(Request $request, Cast $cast): RedirectResponse
    {
        $cast->update($this->validated($request));

        return redirect()->route('admin.cast.index')->with('success', 'Cast berhasil diperbarui.');
    }

    public function destroy(Cast $cast): RedirectResponse
    {
        // Peran milik cast ini ikut terhapus lewat foreign key cascade.
        $cast->delete();

        return redirect()->route('admin.cast.index')->with('success', 'Cast berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:45'],
            'umur' => ['required', 'integer', 'min:1', 'max:120'],
            'bio' => ['required', 'string'],
        ]);
    }
}
