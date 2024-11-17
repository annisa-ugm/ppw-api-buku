<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BukuController extends Controller
{

    public function index (){
        Paginator::useBootstrapFive();
        $batas = 5;
        $data_buku = Buku::all()->sortBy('index');
        $jumlah_buku = Buku::count();
        $total_harga = $data_buku->sum('harga');
        return view('buku.index', compact('data_buku', 'jumlah_buku', 'total_harga'));

        Storage::disk(‘local’)->put(‘file.txt’, ‘Contents’);
        $contents = Storage::get(hujan.jpg’);
        $exists = Storage::disk(‘local’)->exists(hujan.jpg’);

    }

    public function create(){
        return view('buku.create');
    }

    public function store(Request $request)
    {
        Log::info('Masuk ke store method');

        try {
            $this->validate($request, [
                'judul' => 'required|string',
                'penulis' => 'required|string|max:30',
                'harga' => 'required|numeric',
                'tgl_terbit' => 'required|date',
                'foto' => 'image|nullable|max:1999'
            ]);

            $manager = new ImageManager(new Driver());
            if ($request->hasFile('foto')) {
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $extension = $request->file('foto')->getClientOriginalExtension();

                $basename = uniqid() . time();
                $originalFilename = "{$basename}.{$extension}";
                $squareFilename = "{$basename}_square.{$extension}";

                // Simpan gambar original
                $request->file('foto')->storeAs('public/foto', $originalFilename);
                Log::info('Berhasil simpan image asli');
                // Membaca gambar yang di-upload
                $image = $manager->read($request->file('foto')->getPathname());
                // Resize gambar ke ukuran 300x300
                $image->resize(300, 300);
                $image->save(storage_path('app/public/public/foto/' . $squareFilename));
                Log::info('Berhasil simpan resized image');
            } else {
                $originalFilename = 'noimage.png';
                $squareFilename = 'noimage.png';
            }

            $buku = new Buku();
            $buku->judul = $request->judul;
            $buku->penulis = $request->penulis;
            $buku->harga = $request->harga;
            $buku->tgl_terbit = $request->tgl_terbit;
            $buku->foto = $originalFilename; 
            $buku->foto_square = $squareFilename; 
            $buku->save();
            // dd('Data tersimpan!');

            return redirect('/buku')->with('pesan', 'Data buku berhasil disimpan');
        } catch (\Exception $e) {
            Log::error('Error processing image: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    public function search(Request $request) {
        Paginator::useBootstrapFive();
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")
        ->orwhere('penulis','like', "%".$cari."%" )
        ->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $no = $batas * ($data_buku->currentPage() - 1);
        return view('buku.search', compact('jumlah_buku', 'data_buku', 'no',
        'cari'));
    }

    public function destroy($id) {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/buku')->with('hapus', 'Data buku berhasil dihapus');
    }

    public function edit($id) {

        return view('buku.edit', ['buku' => Buku::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' =>'required|date'
        ]);

        $buku = Buku::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect()->route('buku.index')->with('update', 'Data buku berhasil diupdate');
    }


    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'search']);
    }


}


