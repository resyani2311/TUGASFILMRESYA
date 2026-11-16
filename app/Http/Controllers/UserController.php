<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** Admin hanya dapat MELIHAT daftar user. */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $users = User::with('role', 'profile')->withCount('kritiks')
            ->when($keyword !== '', fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")))
            ->orderBy('role_id', 'desc')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'keyword'));
    }
}
