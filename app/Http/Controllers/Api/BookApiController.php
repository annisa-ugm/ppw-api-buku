<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\BookResource;

class BookApiController extends Controller
{
    public function index() {
        $books = Buku::latest()->paginate(5);
        return new BookResource(true, 'List Data Buku', $books);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
        ]);

        $book = Buku::create($validated);

        return new BookResource(true, 'Data Buku Berhasil Ditambahkan', $book);
    }

    public function update(Request $request, $id) {
        $book = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
        ]);

        $book->update($validated);

        return new BookResource(true, 'Data Buku Berhasil Diupdate', $book);
    }

    public function destroy($id) {
        $book = Buku::findOrFail($id);
        $book->delete();

        return new BookResource(true, 'Data Buku Berhasil Dihapus', null);
    }

}
