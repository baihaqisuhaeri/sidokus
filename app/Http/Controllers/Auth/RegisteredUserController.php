<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Satker;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $satkers = Satker::active()->orderBy('tingkatan')->orderBy('nama')->get();
        return view('auth.register', compact('satkers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
            'satker_id' => ['required', 'exists:satkers,id'],
            'nip'       => ['nullable', 'string', 'max:20'],
            'jabatan'   => ['nullable', 'string', 'max:100'],
            'no_hp'     => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'user', // default selalu user
            'satker_id' => $request->satker_id,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'no_hp'     => $request->no_hp,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}