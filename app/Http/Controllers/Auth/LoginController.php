<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login dengan rate limiting
     */
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $throttleKey = Str::transliterate(Str::lower($request->email).'|'.$request->ip());
        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            // Log brute force attempt
            Log::warning('Brute force login detected', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'retry_after' => $seconds,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'throttled' => true,
                    'seconds' => $seconds,
                    'message' => "Terlalu banyak percobaan login gagal. Akun Anda diblokir sementara. Silakan coba lagi dalam {$seconds} detik."
                ], 429);
            }
            
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login gagal. Akun Anda diblokir sementara. Silakan coba lagi dalam {$seconds} detik.",
            ])->status(429);
        }

        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            RateLimiter::clear($throttleKey);
            if ($user->status !== 'aktif') {
                Auth::logout();
                Log::warning('Inactive account login attempt', [
                    'email' => $request->email,
                    'user_id' => $user->id,
                    'ip' => $request->ip(),
                ]);
                
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda tidak aktif. Hubungi administrator.',
                ]);
            }
            
            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->peran,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            $request->session()->flash('login_success_voice', true);
            $request->session()->flash('user_name_voice', $user->nama);
            
            return $this->redirectBasedOnRole($user);
        }

        RateLimiter::hit($throttleKey, 30);
        $attempts = RateLimiter::attempts($throttleKey);
        $remaining = 5 - $attempts;
        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'attempts' => $attempts,
            'remaining' => $remaining,
        ]);

        $message = 'Email atau password yang Anda masukkan salah.';
        if ($attempts >= 3) {
            $message .= " Sisa percobaan: {$remaining}x. Setelah 5x gagal, akun akan diblokir 30 detik.";
        }

        throw ValidationException::withMessages([
            'email' => $message,
        ]);
    }

    protected function redirectBasedOnRole($user)
    {
        $role = $user->role ?? $user->peran;
        $roleRouteMap = [
            'admin' => 'admin.dashboard',
            'guru_bk' => 'guru_bk.dashboard',
            'teacher' => 'guru_bk.dashboard',
            'siswa' => 'student.dashboard',
            'student' => 'student.dashboard',
        ];

        // Get route name for this role
        $routeName = $roleRouteMap[$role] ?? null;

        if ($routeName && \Illuminate\Support\Facades\Route::has($routeName)) {
            return redirect()->intended(route($routeName));
        }

        // If role not recognized, logout and show error
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Role tidak valid: ' . $role
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log logout
        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}