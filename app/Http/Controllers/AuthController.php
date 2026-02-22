<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Repositories\UserRepository;
use App\Models\User;

class AuthController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = $this->userRepository->create($data);
        Auth::login($user);
        return redirect()->route('profile.me')->with('success', 'Registro exitoso');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            return redirect()->route('profile.me')->with('success', 'Inicio de sesión exitoso');
        }
        return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')->with('success', 'Has cerrado sesión');
    }
}
