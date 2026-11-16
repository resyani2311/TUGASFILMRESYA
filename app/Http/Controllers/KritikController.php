<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKritikRequest;
use App\Models\Film;

class KritikController extends Controller
{
    /** User biasa memberi komentar/kritik untuk sebuah film (admin ditolak lewat middleware & request). */
    public function store(StoreKritikRequest $request, Film $film)
    {
        $film->kritiks()->create([
            'comment' => $request->comment,
            'rating'  => $request->rating,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->to(route('movies.show', $film).'#komentar')
            ->with('success', 'Komentar Anda berhasil dikirim.');
    }
}
