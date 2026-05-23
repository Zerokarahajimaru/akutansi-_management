<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

        $users = User::with('admin')
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
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,pegawai',
            // NoTelp is usually associated with the person, if we still want it, we use Admin profile
            'NoTelp_User' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // We still create an Admin profile if we want to store phone numbers
            // or we could just add phone number to the users table.
            // But based on current migrations, let's keep the link if we want to keep the data.
            $id_admin = 'USR-' . strtoupper(bin2hex(random_bytes(4)));
            
            Admin::create([
                'ID_Admin' => $id_admin,
                'Nama_Admin' => $request->name,
                'NoTelp_Admin' => $request->NoTelp_User ?? '-',
                'Alamat_Admin' => '-',
            ]);

            User::create([
                'username' => $request->username,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'ID_Admin' => $id_admin,
            ]);

            DB::commit();
            return redirect()->route('data.user')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::with('admin')->findOrFail($id);
        
        // Security: Non-admin can only edit their own profile
        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Security: Non-admin can only update their own profile
        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,pegawai',
            'NoTelp_User' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        // Security: Non-admin cannot change their own role or other's role
        $role = $request->role;
        if (auth()->user()->role !== 'admin') {
            $role = $user->role; // Force keep original role
        }

        DB::beginTransaction();
        try {
            $user->update([
                'username' => $request->username,
                'name' => $request->name,
                'role' => $role,
            ]);

            if ($request->password) {
                // If it's a non-admin, they are allowed to change their own password
                // but they already passed the check above that they can only edit their OWN id.
                $user->update(['password' => Hash::make($request->password)]);
            }

            if ($user->admin) {
                $user->admin->update([
                    'Nama_Admin' => $request->name,
                    'NoTelp_Admin' => $request->NoTelp_User ?? $user->admin->NoTelp_Admin,
                ]);
            }

            DB::commit();
            return redirect()->route('data.user')->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        DB::beginTransaction();
        try {
            // Delete admin profile first if it exists
            if ($user->admin) {
                $user->admin->delete();
            }
            $user->delete();

            DB::commit();
            return redirect()->route('data.user')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
