<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCastRequest;
use App\Http\Requests\UpdateCastRequest;
use App\Models\Cast;
use Illuminate\Http\Request;

class CastController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $casts = Cast::withCount('perans')
            ->when($keyword !== '', fn ($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.casts.index', compact('casts', 'keyword'));
    }

    public function create()
    {
        return view('admin.casts.form', ['cast' => new Cast()]);
    }

    public function store(StoreCastRequest $request)
    {
        Cast::create($request->validated());

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil ditambahkan.');
    }

    public function edit(Cast $cast)
    {
        return view('admin.casts.form', compact('cast'));
    }

    public function update(UpdateCastRequest $request, Cast $cast)
    {
        $cast->update($request->validated());

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil diperbarui.');
    }

    public function destroy(Cast $cast)
    {
        $cast->perans()->delete();
        $cast->delete();

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil dihapus.');
    }
}
