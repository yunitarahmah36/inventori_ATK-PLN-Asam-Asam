<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user           = Auth::user();
        $totalMaterial  = $user->materials()->count();
        $totalAktivitas = $user->stockMovements()->count();
        $recentMovements = $user->stockMovements()
            ->with('material')
            ->latest()
            ->take(6)
            ->get();

        return view('profile.show', compact('user', 'totalMaterial', 'totalAktivitas', 'recentMovements'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
        ]);

        $user->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password'          => 'required',
            'new_password'              => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'current_password.required'  => 'Password saat ini wajib diisi.',
            'new_password.required'      => 'Password baru wajib diisi.',
            'new_password.min'           => 'Password baru minimal 8 karakter.',
            'new_password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.show')
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                ->with('active_tab', 'password');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diubah.')
            ->with('active_tab', 'password');
    }
}
