<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Contracts\Encryption\DecryptException;

class UserController extends Controller
{
    // Menampilkan halaman utama user
    public function index()
    {
        return view('masteruser.index');
    }

    // Mengambil data user untuk DataTables
    public function getData(Request $request)
{
    if ($request->ajax()) {
        // Hanya ambil user yang belum dihapus
        $data = User::whereNull('deleted_at')->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $actions = '<button class="btn btn-info btn-sm show-user" data-id="'.$row->id.'">Show</button>
                            <button class="btn btn-warning btn-sm edit-user" data-id="'.$row->id.'">Edit</button>
                            <button class="btn btn-danger btn-sm delete-user" data-id="'.$row->id.'">Delete</button>';
                
                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view('users.index');
}

    // Menampilkan detail user
    public function show($id)
    {
        $user = User::find($id);
    
        try {
            // Dekripsi password
            $decryptedPassword = $user->original_password; // Menggunakan accessor getOriginalPasswordAttribute
            Log::info('Decrypted Password', ['password' => $decryptedPassword]);
        } catch (DecryptException $e) {
            Log::error('Decryption failed: ' . $e->getMessage());
            $decryptedPassword = 'Password cannot be decrypted'; // Pesan kesalahan jika dekripsi gagal
        }
    
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'decryptedPassword' => $decryptedPassword
        ]);
    }

    // Menampilkan form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Menyimpan perubahan user
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string'
        ]);

        try {
            $user = User::findOrFail($id);
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            if ($request->filled('password')) {
                $user->password = $validatedData['password'];
            }
            $user->role = $validatedData['role'];
            $user->save();

            return response()->json(['success' => true, 'message' => 'User berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui user']);
        }
    }

    // Menghapus user (soft delete)
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus user']);
        }
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,user',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $validated['password']; // Ini akan di-hash oleh accessor
        $user->original_password = $validated['password']; // Enkripsi password asli
        $user->role = $validated['role'];
        $user->save();

        return response()->json(['success' => true]);
    }

    // Mengembalikan user yang dihapus (restore)
    public function restore($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore(); // Mengembalikan user yang dihapus
            return response()->json(['success' => true, 'message' => 'User berhasil dikembalikan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengembalikan user']);
        }
    }

    // Menghapus user secara permanen (force delete)
    public function forceDelete($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->forceDelete(); // Hapus permanen
            return response()->json(['success' => true, 'message' => 'User berhasil dihapus secara permanen']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus user secara permanen']);
        }
    }
}
