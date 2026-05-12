<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,pegawai',
            'NoTelp_Admin' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            $id_admin = 'ADM-' . strtoupper(Str::random(8));
            
            // Create in admins table
            Admin::create([
                'ID_Admin' => $id_admin,
                'Nama_Admin' => $request->name,
                'NoTelp_Admin' => $request->NoTelp_Admin,
            ]);

            // Create in users table for auth
            User::create([
                'username' => $request->username,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'ID_Admin' => $id_admin,
            ]);

            DB::commit();
            return redirect()->route('data.admin')->with('success', 'User berhasil didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mendaftarkan user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $user = User::where('ID_Admin', $id)->first();
        return view('admin.edit', compact('admin', 'user'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $user = User::where('ID_Admin', $id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,pegawai',
            'NoTelp_Admin' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        DB::beginTransaction();
        try {
            $admin->update([
                'Nama_Admin' => $request->name,
                'NoTelp_Admin' => $request->NoTelp_Admin,
            ]);

            $userData = [
                'name' => $request->name,
                'role' => $request->role,
            ];

            if ($request->password) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            DB::commit();
            return redirect()->route('data.admin')->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        
        // Prevent self-deletion
        if ($admin->ID_Admin === auth()->user()->ID_Admin) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        DB::beginTransaction();
        try {
            // User will be deleted automatically if foreign key cascade is set, 
            // but let's be explicit if needed or let DB handle it.
            // The migration for users table uses cascade.
            $admin->delete();

            DB::commit();
            return redirect()->route('data.admin')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
