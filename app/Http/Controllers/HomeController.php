<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect berdasarkan role user
        if (Auth::check()) {
            $user = Auth::user();
            
            switch ($user->peran) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'guru_bk':
                    return redirect()->route('guru_bk.dashboard');
                case 'siswa':
                    return redirect()->route('student.dashboard');
                default:
                    return redirect('/')->with('error', 'Role tidak dikenali.');
            }
        }

        return redirect('/login');
    }
}