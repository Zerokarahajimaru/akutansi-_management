<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'name');
        $sortDir = $request->input('sort_dir', 'asc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $users = User::when($search, function($q) use ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'NoTelp_User' => 'nullable|string|max:20',
            'Alamat_User' => 'nullable|string',
        ], [
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        try {
            User::create([
                'id' => User::generateId('usr-xyra'),
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'NoTelp_User' => $request->NoTelp_User,
                'Alamat_User' => $request->Alamat_User,
            ]);

            return redirect()->route('data.user')->with('success', 'Pengguna baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mendaftarkan pengguna baru. Silakan coba lagi.')->withInput();
        }
    }

    public function edit($id)
    {
        if (auth()->id() !== $id) {
            return redirect()->route('data.user')->with('error', 'Anda hanya diizinkan untuk mengubah profil Anda sendiri.');
        }

        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->id() !== $id) {
            return abort(403, 'Aksi tidak diizinkan.');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'NoTelp_User' => 'nullable|string|max:20',
            'Alamat_User' => 'nullable|string',
        ]);

        try {
            $data = $request->only(['name', 'username', 'NoTelp_User', 'Alamat_User']);
            
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('data.user')->with('success', 'Informasi pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui informasi pengguna. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy($id)
    {
        return back()->with('error', 'Penghapusan akun tidak diizinkan dalam sistem ini demi keamanan data.');
    }
}
