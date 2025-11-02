<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Support multiple role variants (siswa/student, etc)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $roleMap = [
            'student' => 'siswa',
            'siswa' => 'siswa',
            'admin' => 'admin',
            'guru_bk' => 'guru_bk',
            'teacher' => 'guru_bk',
        ];

        $checkRole = $roleMap[$role] ?? $role;
        $userRole = auth()->user()->peran;

        if ($userRole !== $checkRole) {
            abort(403, 'Unauthorized action. Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}