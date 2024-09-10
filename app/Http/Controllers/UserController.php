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
    // Mengambil data user untuk DataTables
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<button class="btn btn-info btn-sm show-user" data-id="'.$row->id.'">Show</button>
                            <button class="btn btn-warning btn-sm edit-user" data-id="'.$row->id.'">Edit</button>
                            <button class="btn btn-danger btn-sm delete-user" data-id="'.$row->id.'">Delete</button>';
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
        $decryptedPassword = Crypt::decryptString($user->password); // Menggunakan 'password' jika itu yang disimpan
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
            $user->password = bcrypt($validatedData['password']);
        }
        $user->role = $validatedData['role'];
        $user->save();

        return response()->json(['success' => true, 'message' => 'User berhasil diperbarui']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui user']);
    }
}



    // Menghapus user
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

public function store(Request $request)
{
    // Log request data
    \Log::info('Request data: ', $request->all());

    // Validasi data input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|in:admin,user',
    ]);

    if ($validator->fails()) {
        \Log::info('Validation failed: ', $validator->errors()->all()); // Log validasi gagal
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ]);
    }

    // Simpan data user baru
    try {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan.',
        ]);

    } catch (\Exception $e) {
        \Log::error('Exception: ', ['message' => $e->getMessage()]); // Log exception
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menambahkan user.',
        ]);
    }
}
}



