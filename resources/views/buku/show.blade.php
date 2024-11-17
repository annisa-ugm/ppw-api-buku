@extends('auth.layouts')

@section('content')
    <div class="container mt-5">
        <h2>Detail Buku</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h3>{{ $buku->judul }}</h3>
                <p>Penulis: {{ $buku->penulis }}</p>
                <p>Harga: Rp. {{ number_format($buku->harga, 0, ',', '.') }}</p>
                <p>Tanggal Terbit: {{ $buku->tgl_terbit->format('d/m/Y') }}</p>
                <img src="{{ asset('storage/public/foto/' . $buku->foto) }}" style="width: 300px">
            </div>
            <br>
            <a class="btn btn-secondary mt-3" href="{{ url('/buku') }}">Kembali</a>
        </div>
    </div>
@endsection
