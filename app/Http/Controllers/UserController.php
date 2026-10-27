<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $roleFilter = $request->query('role');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter && in_array($roleFilter, array_keys(User::ROLES))) {
            $query->where('role', $roleFilter);
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $stats = [
            'total'          => User::count(),
            'admin'          => User::where('role', User::ROLE_ADMIN)->count(),
            'keuangan'       => User::where('role', User::ROLE_KEUANGAN)->count(),
            'umum'           => User::where('role', User::ROLE_UMUM)->count(),
            'pengelola_buku' => User::where('role', User::ROLE_PENGELOLA_BUKU)->count(),
        ];

        return view('users.index', compact('users', 'stats', 'search', 'roleFilter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => ['required', Rule::in(array_keys(User::ROLES))],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan oleh akun lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Pilihan role tidak valid.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru dengan role "' . $validated['role'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'email'    => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role'     => ['required', Rule::in(array_keys(User::ROLES))],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan oleh akun lain.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.min'      => 'Password minimal 6 karakter jika ingin diubah.',
            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Pilihan role tidak valid.',
        ]);

        $updateData = [
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'Data pengguna "' . $user->name . '" berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna "' . $userName . '" berhasil dihapus dari sistem.');
    }
}
