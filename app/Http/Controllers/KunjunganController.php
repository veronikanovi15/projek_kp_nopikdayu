<?php

namespace App\Http\Controllers;
use App\Models\MKunjungan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Jika filter ada, tampilkan data yang difilter
        if ($startDate && $endDate) {
            $kunjungans = MKunjungan::whereBetween('tanggal_kunjungan', [$startDate, $endDate])->get();
        } else {
            // Jika tidak ada filter, tampilkan semua data
            $kunjungans = MKunjungan::all();
        }
    
        return view('kunjungan.index', compact('kunjungans', 'startDate', 'endDate'));
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
    
        $kunjungan = new MKunjungan();
        $kunjungan->tanggal_kunjungan = $request->input('tanggal_kunjungan');
        $kunjungan->pengunjung = $request->input('pengunjung');
        $kunjungan->kota_asal = $request->input('kota_asal');
        $kunjungan->penerima = $request->input('penerima');

        // $path = $request->file('gambar')->store('images', 'public');
        // $kunjungan->gambar = $path;
    
        // if ($request->hasFile('gambar')) {
        //     $file = $request->file('gambar');
            
        //     // Ubah nama file menjadi nama pengunjung
        //     $fileName = Str::slug($request->input('pengunjung')) . '-' . time() . '.' . $file->getClientOriginalExtension();
        //     $filePath = $file->storeAs('public/images', $fileName);
            
        //     $kunjungan->gambar = $filePath;
        // }
        // 
        $image = $request->gambar;
        if (!empty($image)) {
            $path = public_path().'/images/';
            
            // Mengambil nama pengunjung dan mengubahnya menjadi slug
            $pengunjungName = preg_replace('/\s+/', '-', strtolower($request->input('pengunjung')));
            
            // Mengambil ekstensi file asli
            $extension = $image->getClientOriginalExtension();
            
            // Membuat nama file dengan nama pengunjung dan ekstensi file
            $nameFile = $pengunjungName . '-' . rand(10,100) . '.' . $extension;
            
            // Memindahkan file ke folder images
            $image->move($path, $nameFile);
        } else {
            $nameFile = "-";
        }

        $kunjungan->gambar = $nameFile;

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
        $kunjungan = MKunjungan::findOrFail($id);
        $url = Storage::url($kunjungan->gambar);
            return view('kunjungan.show', compact('kunjungan', 'url'));
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
    $kunjungan->tanggal_kunjungan = $request->input('tanggal_kunjungan');
    $kunjungan->pengunjung = $request->input('pengunjung');
    $kunjungan->kota_asal = $request->input('kota_asal');
    $kunjungan->penerima = $request->input('penerima');

    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($kunjungan->gambar && $kunjungan->gambar !== '-') {
            $oldImagePath = public_path().'/images/'.$kunjungan->gambar;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $image = $request->gambar;

        // Mengambil nama pengunjung dan mengubahnya menjadi slug
        $pengunjungName = preg_replace('/\s+/', '-', strtolower($request->input('pengunjung')));
        
        // Mengambil ekstensi file asli
        $extension = $image->getClientOriginalExtension();
        
        // Membuat nama file dengan nama pengunjung dan ekstensi file
        $nameFile = $pengunjungName . '-' . rand(10,100) . '.' . $extension;
        
        // Memindahkan file ke folder images
        $path = public_path().'/images/';
        $image->move($path, $nameFile);

        $kunjungan->gambar = $nameFile;
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

        if ($kunjungan->gambar) {
            // Hapus gambar dari storage
            Storage::delete($kunjungan->gambar);
        }

        $kunjungan->delete();

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dihapus.');
    }

   

    public function cetakLaporan(Request $request)
    {
        // Ambil data filter dari permintaan
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Ambil data kunjungan sesuai filter, atau ambil semua data jika tidak ada filter
    if ($startDate && $endDate) {
        $kunjungans = MKunjungan::whereBetween('tanggal_kunjungan', [$startDate, $endDate])->get();
    } else {
        $kunjungans = MKunjungan::all();
    }

    // Generate PDF dan kembalikan
    $pdf = \PDF::loadView('kunjungan.laporan', compact('kunjungans'));
    return $pdf->download('laporan_kunjungan.pdf');
    }

    
}
