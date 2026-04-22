<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function profil()
    {
        return view('user.profil');
    }

    public function hasilPrediksi()
    {
        return view('user.hasil_prediksi');
    }
}
