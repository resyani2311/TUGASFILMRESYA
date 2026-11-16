<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeranRequest;
use App\Http\Requests\UpdatePeranRequest;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Peran;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $perans = Peran::with('film', 'cast')
            ->when($keyword !== '', fn ($q) => $q->where('actor', 'like', "%{$keyword}%")
                ->orWhereHas('film', fn ($f) => $f->where('title', 'like', "%{$keyword}%"))
                ->orWhereHas('cast', fn ($c) => $c->where('name', 'like', "%{$keyword}%")))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.perans.index', compact('perans', 'keyword'));
    }

    public function create()
    {
        return view('admin.perans.form', $this->options(new Peran()));
    }

    public function store(StorePeranRequest $request)
    {
        Peran::create($request->validated());

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil ditambahkan.');
    }

    public function edit(Peran $peran)
    {
        return view('admin.perans.form', $this->options($peran));
    }

    public function update(UpdatePeranRequest $request, Peran $peran)
    {
        $peran->update($request->validated());

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil diperbarui.');
    }

    public function destroy(Peran $peran)
    {
        $peran->delete();

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil dihapus.');
    }

    private function options(Peran $peran): array
    {
        return [
            'peran' => $peran,
            'films' => Film::orderBy('title')->orderBy('year')->get(['id', 'title', 'year']),
            'casts' => Cast::orderBy('name')->get(['id', 'name']),
        ];
    }
}
