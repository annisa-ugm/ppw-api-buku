<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            @if (count($errors) > 0)
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif

            <h4 class="text-center mb-4">Tambah Buku</h4>
            <form method="post" action="{{route('buku.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul">
                </div>
                <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" name="penulis" id="penulis">
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" class="form-control" name="harga" id="harga">
                </div>
                <div class="mb-3">
                    <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" class="form-control" name="tgl_terbit" id="tgl_terbit">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <div class="col-md-6">
                      <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" value="{{ old('foto') }}">
                      @if ($errors->has('foto'))
                      <span class="text-danger">{{ $errors->first('foto') }}</span>
                      @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a class="btn btn-secondary" href="{{'/buku'}}">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
