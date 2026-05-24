<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'name');
        $sortDir = $request->input('sort_dir', 'asc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') {
            $perPage = 9999;
        }

        $users = User::orderBy($sortBy, $sortDir)
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
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,pegawai',
            'NoTelp_User' => 'nullable|string|max:20',
            'Alamat_User' => 'nullable|string',
        ]);

        try {
            User::create([
                'username' => $request->username,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'NoTelp_User' => $request->NoTelp_User,
                'Alamat_User' => $request->Alamat_User,
            ]);

            return redirect()->route('data.user')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name' => 'required|string|max:255',
            'role' => 'nullable|in:admin,pegawai',
            'NoTelp_User' => 'nullable|string|max:20',
            'Alamat_User' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        $role = $user->role;
        if (auth()->user()->role === 'admin' && $request->filled('role')) {
            $role = $request->role;
        }

        try {
            $user->update([
                'username' => $request->username,
                'name' => $request->name,
                'role' => $role,
                'NoTelp_User' => $request->NoTelp_User,
                'Alamat_User' => $request->Alamat_User,
            ]);

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            Cache::forget('user_auth_id_' . $user->id);

            return redirect()->route('data.user')->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            $user->delete();
            return redirect()->route('data.user')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
