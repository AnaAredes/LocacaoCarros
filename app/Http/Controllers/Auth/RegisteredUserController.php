<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use PgSql\Lob;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'nif' => ['required', 'max:9', 'unique:' . User::class],
            ]);
    
            $user = User::create([
                'name' => ucwords(strtolower($request->name)),
                'email' => $request->email,
                'nif' => $request->nif,
                'role' => 'client',
                'password' => Hash::make($request->password),
            ]);
    
            Auth::login($user);
            
            return redirect('/')->with('success', 'Bem-vindo!');
        } catch (\Throwable $e) {
            return redirect('/')->with('error', 'Erro ao registar.');
        }
    }
}
