<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

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

    public function create(){
        return view('buku.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' =>'required|date',
            'foto' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('foto')) {
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('foto')->getClientOriginalExtension();
            $fileNameSimpan = $filename.'_'.time().'.'.$extension;
            // $request->file('foto')->storeAs('public', $fileNameSimpan);

            $path = $request->file('foto')->storeAs('public/fotos', $fileNameSimpan);
        }

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->foto = $path;
        // $buku->foto = $fileNameSimpan?? null;
        $buku->save();

        return redirect('/buku')->with('pesan', 'Data buku berhasil di simpan');

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


