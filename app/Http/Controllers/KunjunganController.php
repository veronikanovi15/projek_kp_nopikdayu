<?php

namespace App\Http\Controllers;
use App\Models\MKunjungan;

use Illuminate\Http\Request;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data kunjungan dari database
        $kunjungans = MKunjungan::all();
        
        // Kirim data ke tampilan
        return view('kunjungan.index', compact('kunjungans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kunjungan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tanggal_kunjungan' => 'required|date_format:Y-m-d',
            'pengunjung' => 'required|string|max:255',
            'kota_asal' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'gambar' => 'nullable|file|mimes:jpg,png|max:2048',
        ]);
    
        // Ambil tanggal dari input
        $tanggalInput = $request->input('tanggal_kunjungan');
        
        // Konversi tanggal ke format yang sesuai untuk database
        $tanggalDatabase = Carbon::createFromFormat('Y-m-d', $tanggalInput)->format('Y-m-d');
        
        // Simpan data ke database
        $kunjungan = new MKunjungan();
        $kunjungan->tanggal_kunjungan = $tanggalDatabase;
        $kunjungan->pengunjung = $request->input('pengunjung');
        $kunjungan->kota_asal = $request->input('kota_asal');
        $kunjungan->penerima = $request->input('penerima');
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filePath = $file->store('public/images');
            $kunjungan->gambar = $filePath;
        }
        
        $kunjungan->save();
    
        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $kunjungan = MKunjungan::findOrFail($id);
            return view('kunjungan.update', compact('kunjungan'));
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
        $request->validate([
            'tanggal_kunjungan' => 'required|date_format:Y-m-d',
            'pengunjung' => 'required|string|max:255',
            'kota_asal' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'gambar' => 'nullable|file|mimes:jpg,png|max:2048',
        ]);
    
        $kunjungan = MKunjungan::findOrFail($id);
        $kunjungan->tanggal_kunjungan = Carbon::createFromFormat('Y-m-d', $request->input('tanggal_kunjungan'))->format('Y-m-d');
        $kunjungan->pengunjung = $request->input('pengunjung');
        $kunjungan->kota_asal = $request->input('kota_asal');
        $kunjungan->penerima = $request->input('penerima');
    
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($kunjungan->gambar) {
                Storage::delete($kunjungan->gambar);
            }
    
            $file = $request->file('gambar');
            $filePath = $file->store('public/images');
            $kunjungan->gambar = $filePath;
        }
    
        $kunjungan->save();
    
        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kunjungan = MKunjungan::findOrFail($id);
        $kunjungan -> delete();

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dihapus.');
    }
}
