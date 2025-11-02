<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('kelas.jurusan');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis_nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('filter_role') && $request->filter_role != '') {
            $query->where('peran', $request->filter_role);
        }

        // Filter by status
        if ($request->has('filter_status') && $request->filter_status != '') {
            $query->where('status', $request->filter_status);
        }

        // Filter by kelas
        if ($request->has('filter_kelas') && $request->filter_kelas != '') {
            $query->where('kelas_id', $request->filter_kelas);
        }

        // Pagination
        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get all kelas for filter dropdown
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();

        return view('admin.management-pengguna.daftar-pengguna', compact('users', 'kelasList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasList = Kelas::with('jurusan')->get();
        return view('admin.management-pengguna.tambah-akun', compact('kelasList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules with stronger password policy
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:guru_bk,siswa',
            'nama_lengkap' => 'required|string|max:100',
            'nik_nip' => 'required|string|max:20|unique:users,nis_nip',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // Must contain at least one lowercase letter
                'regex:/[A-Z]/',      // Must contain at least one uppercase letter
                'regex:/[0-9]/',      // Must contain at least one digit
                'regex:/[@$!%*#?&]/', // Must contain at least one special character
            ],
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'telepon' => 'required|string|max:15',
            'status' => 'required|in:aktif,non-aktif',
            'alamat' => 'required|string',
            'kelas_id' => 'nullable|exists:kelas,id'
        ], [
            'role.required' => 'Role harus dipilih.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik_nip.required' => 'NIK/NIP wajib diisi.',
            'nik_nip.unique' => 'NIK/NIP sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*#?&).',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'status.required' => 'Status akun harus dipilih.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create new user
            $user = User::create([
                'nis_nip' => $request->nik_nip,
                'nama' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'peran' => $request->role,
                'status' => $request->status,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telepon' => $request->telepon,
                'kelas_id' => $request->role === 'siswa' ? $request->kelas_id : null
            ]);

            // Log user creation
            Log::info('New user created', [
                'admin_id' => auth()->id(),
                'admin_email' => auth()->user()->email,
                'new_user_id' => $user->id,
                'new_user_email' => $user->email,
                'new_user_role' => $user->peran,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Akun pengguna berhasil ditambahkan!',
                'data' => $user
            ], 201);

        } catch (\Exception $e) {
            // Log error
            Log::error('Failed to create user', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan akun pengguna.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('kelas.jurusan')->findOrFail($id);
        return view('admin.management-pengguna.detail-pengguna', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $kelasList = Kelas::with('jurusan')->get();
        return view('admin.management-pengguna.edit-akun', compact('user', 'kelasList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:guru_bk,siswa',
            'nama_lengkap' => 'required|string|max:100',
            'nik_nip' => ['required', 'string', 'max:20', Rule::unique('users', 'nis_nip')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'telepon' => 'required|string|max:15',
            'status' => 'required|in:aktif,non-aktif',
            'alamat' => 'required|string',
            'kelas_id' => 'nullable|exists:kelas,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Save old data for logging
            $oldData = [
                'email' => $user->email,
                'role' => $user->peran,
                'status' => $user->status,
            ];
            
            // Update user data
            $user->nis_nip = $request->nik_nip;
            $user->nama = $request->nama_lengkap;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->peran = $request->role;
            $user->status = $request->status;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->alamat = $request->alamat;
            $user->no_telepon = $request->telepon;
            $user->kelas_id = $request->role === 'siswa' ? $request->kelas_id : null;
            $user->save();

            // Log user update
            Log::info('User data updated', [
                'admin_id' => auth()->id(),
                'admin_email' => auth()->user()->email,
                'updated_user_id' => $user->id,
                'old_data' => $oldData,
                'new_data' => [
                    'email' => $user->email,
                    'role' => $user->peran,
                    'status' => $user->status,
                ],
                'password_changed' => $request->filled('password'),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil diperbarui!',
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            // Log error
            Log::error('Failed to update user', [
                'admin_id' => auth()->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data pengguna.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                // Log attempt to delete own account
                Log::warning('Admin attempted to delete own account', [
                    'admin_id' => auth()->id(),
                    'ip' => request()->ip(),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun sendiri.'
                ], 403);
            }

            // Save user data for logging before deletion
            $deletedUserData = [
                'id' => $user->id,
                'email' => $user->email,
                'nama' => $user->nama,
                'role' => $user->peran,
            ];

            $user->delete();

            // Log user deletion
            Log::warning('User account deleted', [
                'admin_id' => auth()->id(),
                'admin_email' => auth()->user()->email,
                'deleted_user' => $deletedUserData,
                'ip' => request()->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Akun pengguna berhasil dihapus!'
            ], 200);

        } catch (\Exception $e) {
            // Log error
            Log::error('Failed to delete user', [
                'admin_id' => auth()->id(),
                'user_id' => $id,
                'error' => $e->getMessage(),
                'ip' => request()->ip(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus akun pengguna.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kelas list (for AJAX)
     */
    public function getKelasList()
    {
        $kelasList = Kelas::with('jurusan')->get();
        return response()->json([
            'success' => true,
            'data' => $kelasList
        ]);
    }
}
