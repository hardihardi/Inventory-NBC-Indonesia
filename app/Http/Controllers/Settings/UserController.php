<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     */
    public function index()
    {
        // Gunakan get() untuk mengirim semua data ke DataTables
        $users = User::latest()->get();
        return view('settings.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        return view('settings.users.create');
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,staff_gudang,kepala_gudang,finance,produksi,procurement'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'required' => ':attribute wajib diisi.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus format jpg, jpeg, atau png.',
            'max' => ':attribute maksimal 2MB.',
        ], [
            'name' => 'Nama Lengkap',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'phone' => 'Telepon',
            'image' => 'Foto Profil',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'status' => 'active',
        ];

        if ($request->hasFile('image')) {
            $userData['image'] = $request->file('image')->store('users', 'public');
        }

        User::create($userData);
        \App\Models\ActivityLog::log('Tambah User', "Menambahkan user baru: {$request->name} ({$request->role})");

        return redirect()->route('settings.users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit user.
     */
    public function edit(User $user)
    {
        return view('settings.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,staff_gudang,kepala_gudang,finance,produksi,procurement'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah terdaftar.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
        ], [
            'name' => 'Nama Lengkap',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'phone' => 'Telepon',
        ]);

        $userData = $request->only('name', 'email', 'role', 'status', 'phone');
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($user->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image);
            }
            $userData['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($userData);
        \App\Models\ActivityLog::log('Edit User', "Memperbarui data user: {$user->name}");

        return redirect()->route('settings.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(Request $request, User $user)
    {
        // Pengecekan krusial: jangan biarkan user menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            $errorMessage = 'Anda tidak dapat menghapus akun Anda sendiri.';
            if ($request->ajax()) {
                return response()->json(['error' => $errorMessage], 403); // 403 Forbidden
            }
            return redirect()->route('settings.users.index')->with('error', $errorMessage);
        }

        $userName = $user->name;
        
        // Hapus foto jika ada
        if ($user->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image);
        }
        
        $user->delete();
        \App\Models\ActivityLog::log('Hapus User', "Menghapus user: {$userName}");

        $successMessage = 'User "' . $userName . '" berhasil dihapus.';
        if ($request->ajax()) {
            return response()->json(['success' => $successMessage]);
        }
        
        return redirect()->route('settings.users.index')->with('success', $successMessage);
    }
}
