<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>


@extends('auth.layouts')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-center">Daftar Buku</h2>
            @auth
                @if (Auth::user()->level === 'admin')
                    <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
                @endif
            @endauth
        </div>

        @if(Session::has('pesan'))
        <div class="alert alert-success mt-3">{{ Session::get('pesan') }}</div>
        @endif
        @if(Session::has('hapus'))
        <div class="alert alert-success mt-3">{{ Session::get('hapus') }}</div>
        @endif
        @if(Session::has('update'))
        <div class="alert alert-success mt-3">{{ Session::get('update') }}</div>
        @endif

        <table id="datatable" class="table table-bordered table-hover mt-4">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nomor</th>
                    <th>Foto</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tanggal Terbit</th>
                    @auth
                        @if (Auth::user()->level === 'admin')
                            <th>Update</th>
                            <th>Delete</th>
                        @endif
                    @endauth
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $index => $buku)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/public/foto/' . $buku->foto_square) }}" style="width: 150px">
                        </td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ "Rp. ".number_format($buku->harga, 0, ',', '.') }}</td>
                        <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                        @auth
                            @if (Auth::user()->level === 'admin')
                                <td>
                                    <a class="btn btn-warning" href="{{ route('buku.edit', $buku->id) }}">Update</a>
                                </td>
                                <td>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin mau di hapus?')" type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            @endif
                        @endauth
                        <td>
                            <a class="btn btn-info" href="{{ route('buku.show', $buku->id) }}">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
        });
    });
</script>
</body>
</html>
