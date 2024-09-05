<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables; // Pastikan Anda mengimpor DataTables

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin'); // Middleware untuk memastikan hanya admin yang dapat mengakses
    }

    /**
     * Menampilkan daftar semua pengguna.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return view('masteruser.index'); // Tampilkan view untuk DataTables
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch users'], 500);
        }
    }

    public function create()
    {
        try {
            return view('masteruser.create'); // Pastikan ada view untuk form pembuatan user
        } catch (\Exception $e) {
            Log::error('Error displaying create form: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menampilkan form pembuatan user'], 500);
        }
    }

    /**
     * Mengambil data pengguna untuk DataTables.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        $query = User::query();
    
        // Filter pencarian jika diperlukan
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
    
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                return '<a href="'.route('masteruser.show', $row->id).'" class="btn btn-info btn-sm">Show</a>
                        <a href="'.route('masteruser.edit', $row->id).'" class="btn btn-warning btn-sm">Edit</a>
                        <a href="'.route('masteruser.destroy', $row->id).'" class="btn btn-danger btn-sm delete-user">Hapus</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    


    /**
     * Menyimpan pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
{
    // Validasi request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed', // 'confirmed' memastikan password dan konfirmasi cocok
    ]);

    try {
        // Enkripsi password sebelum menyimpannya
        $encryptedPassword = Crypt::encryptString($request->password);

        // Simpan data pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $encryptedPassword, // Simpan password terenkripsi
            'role' => $request->is_admin ? 'admin' : 'user', // Sesuaikan role
        ]);

        Log::info('User created successfully: ' . $user->id);
        return redirect()->route('masteruser.index')->with('success', 'User berhasil disimpan'); // Redirect ke halaman user list
    } catch (\Exception $e) {
        Log::error('Error creating user: ' . $e->getMessage());
        return back()->with('error', 'Gagal menyimpan user');
    }
}

    /**
     * Memperbarui data pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi permintaan
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $id,
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            // Temukan pengguna yang ingin diperbarui
            $user = User::findOrFail($id);

            // Cek izin akses dengan policy
            $this->authorize('update', $user);

            // Perbarui data pengguna
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            Log::info('User updated successfully: ' . $user->id);

            // Kembalikan respons sukses
            return response()->json(['success' => 'User updated successfully.'], 200);

        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update user.'], 500);
        }
    }

    public function edit($id)
{
    try {
        $user = User::findOrFail($id); // Ambil pengguna berdasarkan ID
        return view('masteruser.edit', compact('user')); // Tampilkan view edit dengan data pengguna
    } catch (\Exception $e) {
        Log::error('Error displaying edit form: ' . $e->getMessage());
        return redirect()->route('masteruser.index')->with('error', 'Gagal menampilkan form edit pengguna');
    }
}


    /**
     * Menghapus pengguna.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
{
    $authUser = auth()->user();

    // Temukan pengguna yang akan dihapus
    $user = User::findOrFail($id);

    // Pastikan pengguna yang sedang login memiliki izin untuk menghapus pengguna ini
    $this->authorize('delete', $user);

    try {
        $user->delete();
        Log::info('User deleted successfully: ' . $user->id);

        return response()->json(['success' => 'User deleted successfully.'], 200);
    } catch (\Exception $e) {
        Log::error('Error deleting user: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to delete user.'], 500);
    }
}


    /**
     * Menampilkan detail pengguna.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    

public function show($id)
{
    // Temukan user berdasarkan ID
    $user = User::findOrFail($id);

    // Dekripsi password jika perlu
    $decryptedPassword = Crypt::decryptString($user->password);

    // Tampilkan tampilan dengan data user
    return view('masteruser.show', compact('user', 'decryptedPassword'));
}

    

}
