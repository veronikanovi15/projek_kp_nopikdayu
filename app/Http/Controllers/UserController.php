<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Contracts\Encryption\DecryptException;

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
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->get();

        return view('masteruser.index', compact('users'));
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
        if ($request->ajax()) {
            // Inisialisasi query untuk mengambil data user
            $data = User::query();
    
            // Cek apakah ada input pencarian
            if ($request->has('search') && !empty($request->search['value'])) {
                $search = $request->search['value']; // Mengambil nilai pencarian
    
                // Tambahkan kondisi pencarian pada query
                $data->where(function($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
    
            // Mengembalikan data ke DataTables
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<a href="'.route('masteruser.edit', $row->id).'" class="btn btn-warning btn-sm">Edit</a>
                            <a href="'.route('masteruser.destroy', $row->id).'" class="btn btn-danger btn-sm delete-user" data-id="'.$row->id.'">Delete</a>';
                          
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    


    /**
     * Menyimpan pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   
     public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string|in:admin,user', // Validasi untuk role
    ]);

    Log::info('Storing user data', [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'role' => $request->input('role'),
    ]);

    $user = new User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = $request->input('password');
    $user->original_password = $request->input('password');
    $user->role = $request->input('role');
    $user->save();

    return redirect()->route('masteruser.index');
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
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:6|confirmed',
        'role' => 'required|in:admin,user',
    ]);

    Log::info('Updating user', [
        'user_id' => $user->id,
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'role' => $request->input('role'),
    ]);

    $user->name = $request->input('name');
    $user->email = $request->input('email');

    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    $user->role = $request->input('role');
    $user->save();

    return response()->json(['success' => true]);
}





public function edit($id)
{
    $user = User::findOrFail($id);
    return view('masteruser.edit', compact('user'));
}

    /**
     * Menghapus pengguna.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    // Controller saat menghapus
    public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus',
        ]);
    } catch (\Exception $e) {
        Log::error('Exception during delete: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menghapus user',
        ]);
    }
}










    /**
     * Menampilkan detail pengguna.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    // Di controller admin
    public function show($id)
    {
        $user = User::find($id);
        
        try {
            $decryptedPassword = $user->original_password; // Mengakses metode akses
            Log::info('Decrypted Password', ['password' => $decryptedPassword]);
        } catch (DecryptException $e) {
            Log::error('Decryption failed: ' . $e->getMessage());
            $decryptedPassword = 'Password cannot be decrypted';
        }
    
        return view('masteruser.show', compact('user', 'decryptedPassword'));
    }
    



}
