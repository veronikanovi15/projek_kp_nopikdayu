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
            $data = User::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('masteruser.edit', $row->id).'" class="btn btn-primary btn-sm">Edit</a>
                            <a href="'.route('masteruser.destroy', $row->id).'" class="btn btn-danger btn-sm delete-user">Delete</a>';
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
    $validator = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'unique:users,email,' . $id,
        ],
        'password' => 'nullable|string|min:8|confirmed',
        'role' => ['required', Rule::in(['admin', 'user'])], // Validasi role
    ]);

    try {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
            'role' => $request->role, // Update role jika diperlukan
        ]);

        Log::info('User updated successfully: ' . $user->id);

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
    $user = User::findOrFail($id);
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
