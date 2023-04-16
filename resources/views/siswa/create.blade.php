@extends('main.navbar')

@section('content')
<section id="hero" class="bg-dark py-5">
    <div class="container">
        <div class="text-center text-white">
            <h1>SISWA</h1>
            <h4>Tambah Data Siswa</h4>
        </div>
    </div>
</section>

<section id="blog" class="mt-4">
    <div class="container">
        <div class="row mt-5 gy-4 justify-content-center">
            <div class="col-lg-10">
                <div class="row mb-3">
                    <div class="col">
                        <h2>Add Siswa</h2>
                    </div>
                    <div class="col text-end">
                        <a href="{{ url('/siswa/tampil') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
                <form action="{{ url('/siswa/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control" />
                    </div>

                    <div class="form-group mb-2">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                    </div>

                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group mb-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group mb-2">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select">
                            <option value="">Silahkan Pilih</option>
                            @foreach ($kelas as $kls)
                            <option value="{{ $kls->id }}">{{ $kls->kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="no_telp">No.Telp</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control mb-2" />
                    </div>

                    <div class="mt-3 mb-5">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection