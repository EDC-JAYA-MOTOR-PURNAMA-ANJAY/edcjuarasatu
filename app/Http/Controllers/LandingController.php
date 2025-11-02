<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman landing utama
     */
    public function index()
    {
        return view('landing.index');
    }

    /**
     * Menampilkan halaman about
     */
    public function about()
    {
        return view('landing.about');
    }
}