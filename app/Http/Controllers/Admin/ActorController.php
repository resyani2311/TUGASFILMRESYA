<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Cast;
use App\Models\Film;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Pengelolaan "Peran": tokoh yang diperankan seorang Cast di sebuah Film.
 */
class ActorController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $perans = Actor::query()
            ->with(['film', 'cast'])
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', '%'.$q.'%')
                    ->orWhereHas('film', fn ($f) => $f->where('judul', 'like', '%'.$q.'%'))
                    ->orWhereHas('cast', fn ($c) => $c->where('nama', 'like', '%'.$q.'%'));
            }))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.perans.index', compact('perans', 'q'));
    }

    public function create(): View
    {
        return view('admin.perans.create', $this->options());
    }

    public function store(Request $request): RedirectResponse
    {
        Actor::create($this->validated($request));

        return redirect()->route('admin.actor.index')->with('success', 'Peran berhasil ditambahkan.');
    }

    public function show(Actor $actor): View
    {
        $actor->load(['film', 'cast']);

        return view('admin.perans.show', ['peran' => $actor]);
    }

    public function edit(Actor $actor): View
    {
        return view('admin.perans.edit', ['peran' => $actor] + $this->options());
    }

    public function update(Request $request, Actor $actor): RedirectResponse
    {
        $actor->update($this->validated($request, $actor));

        return redirect()->route('admin.actor.index')->with('success', 'Peran berhasil diperbarui.');
    }

    public function destroy(Actor $actor): RedirectResponse
    {
        $actor->delete();

        return redirect()->route('admin.actor.index')->with('success', 'Peran berhasil dihapus.');
    }

    /**
     * @return array{films: \Illuminate\Support\Collection, casts: \Illuminate\Support\Collection}
     */
    private function options(): array
    {
        return [
            'films' => Film::orderBy('judul')->get(['id', 'judul', 'tahun']),
            'casts' => Cast::orderBy('nama')->get(['id', 'nama']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Actor $peran = null): array
    {
        return $request->validate([
            'film_id' => ['required', 'exists:films,id'],
            'cast_id' => ['required', 'exists:casts,id'],
            'nama' => [
                'required', 'string', 'max:45',
                Rule::unique('perans', 'nama')
                    ->where('film_id', $request->input('film_id'))
                    ->where('cast_id', $request->input('cast_id'))
                    ->ignore($peran?->id),
            ],
        ], [
            'nama.unique' => 'Peran ini sudah terdaftar untuk cast dan film yang sama.',
        ], ['film_id' => 'film', 'cast_id' => 'cast', 'nama' => 'nama peran']);
    }
}
