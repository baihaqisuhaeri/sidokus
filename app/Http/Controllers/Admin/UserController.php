<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Satker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('satker');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('satker_id')) {
            $query->where('satker_id', $request->satker_id);
        }

        $users = $query->latest()->paginate(10);
        $satkers = Satker::active()->orderBy('tingkatan')->orderBy('nama')->get();

        return view('admin.users.index', compact('users', 'satkers'));
    }

    public function create()
    {
        $satkers = Satker::active()->orderBy('tingkatan')->orderBy('nama')->get();
        return view('admin.users.create', compact('satkers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'role'       => ['required', 'in:admin,user'],
            'satker_id'  => ['required', 'exists:satkers,id'],
            'nip'        => ['nullable', 'string', 'max:20'],
            'jabatan'    => ['nullable', 'string', 'max:100'],
            'no_hp'      => ['nullable', 'string', 'max:20'],
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'satker_id' => $request->satker_id,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'no_hp'     => $request->no_hp,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $satkers = Satker::active()->orderBy('tingkatan')->orderBy('nama')->get();
        return view('admin.users.edit', compact('user', 'satkers'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'      => ['required', 'in:admin,user'],
            'satker_id' => ['required', 'exists:satkers,id'],
            'nip'       => ['nullable', 'string', 'max:20'],
            'jabatan'   => ['nullable', 'string', 'max:100'],
            'no_hp'     => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'satker_id' => $request->satker_id,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'no_hp'     => $request->no_hp,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil diperbarui.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Password user berhasil direset.');
    }

    public function destroy(Request $request, User $user)
{
    if ($user->id === $request->user()->id) {
        return redirect()->route('admin.users.index')
                         ->with('error', 'Tidak bisa menghapus akun sendiri.');
    }

    $user->delete();

    return redirect()->route('admin.users.index')
                     ->with('success', 'User berhasil dihapus.');
}
}