<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aksess;

class AksesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Aksess::query();

        // Jika ada parameter 'search', tambahkan kondisi pencarian
        if ($request->has('search')) {  // Ubah $Request menjadi $request
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('url', 'like', '%' . $request->search . '%')
                  ->orWhere('username', 'like', '%' . $request->search . '%');
        }
    
        // Eksekusi query dan dapatkan hasilnya
        $akses = $query->get();
    
        // Kirimkan hasil ke view 'akses.index'
        return view('akses.index', ['akses' => $akses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('akses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'url' => 'required',
            'username' => 'required',
            'password' => 'required',
            'keterangan' => 'required',
        ]);

        Aksess::create($validated);

        return redirect("/akses")->with("status", "Data berhasil disimpan!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $akses = Aksess::findOrFail($id);
        return view('akses.show', compact('akses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $akses = Aksess::findOrFail($id);
        return view('akses.edit', compact('akses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'url' => 'required',
            'username' => 'required',
            'password' => 'required',
            'keterangan' => 'required',
        ]);

        $akses = Aksess::findOrFail($id);
        $akses->update($validated);

        return redirect("/akses")->with("status", "Data berhasil diperbarui!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $akses = Aksess::findOrFail($id);
        $akses->delete();

        return redirect("/akses")->with("status", "Data berhasil dihapus!");
    }
}
