@extends('main.navbar')

@section('content')
<section id="hero" class="bg-dark py-5">
    <div class="container">
        <div class="text-center text-white">
            <h1>SISWA</h1>
            <h4>Edit Data Siswa</h4>
        </div>
    </div>
</section>

<section id="blog" class="mt-4">
    <div class="container">
        <div class="row mt-5 gy-4 justify-content-center">
            <div class="col-lg-10">
                <div class="row mb-3">
                    <div class="col">
                        <h2>Update Siswa</h2>
                    </div>
                    <div class="col text-end">
                        <a href="{{ url('/siswa/tampil') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
                <form action="{{ url('/siswa/update' . '/' . $siswa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $siswa->id }}">
                    <div class="form-group mb-2">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control" required value="{{ $siswa->nis }}"/>
                    </div>

                    <div class="form-group mb-2">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required value="{{ $siswa->user->nama }}">
                    </div>

                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required value="{{ $siswa->user->email }}">
                    </div>

                    <div class="form-group mb-2">
                        <label for="password">Password</label>
                        <small>Diisi jika ingin diganti*</small>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group mb-2">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select" required>
                            <option value="" disabled >Silahkan Pilih</option>
                            @foreach ($kelas as $kls)
                            <option {{ $siswa->kelas_id == $kls->id ? 'selected' : '' }} value="{{ $kls->id }}">{{ $kls->kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $siswa->alamat }}" required>
                    </div>

                    <div class="form-group">
                        <label for="no_telp">No.Telp</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control mb-2" value="{{ $siswa->no_telp }}" required />
                    </div>

                    <div class="mt-3 mb-5">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection