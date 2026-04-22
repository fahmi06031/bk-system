<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

public function login()
{

// jika sudah login langsung ke dashboard
if(Auth::check())
{
return redirect('/admin/dashboard');
}

return view('auth.login');

}


public function authenticate(Request $request)
{

$credentials = $request->validate([

'email' => 'required|email',
'password' => 'required'

]);

if(Auth::attempt($credentials))
{

$request->session()->regenerate();

return redirect('/admin/dashboard');

}

return back()->with('error','Email atau Password salah');

}


public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // FIX DI SINI
}

}
