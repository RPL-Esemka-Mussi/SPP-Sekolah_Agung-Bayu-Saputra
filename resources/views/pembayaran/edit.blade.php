@extends('main.navbar')

@section('content')
<section id="hero" class="bg-dark py-5">
    <div class="container">
        <div class="text-center text-white">
            <h1>Pembayaran</h1>
            <h4>Edit Data Pembayaran</h4>
        </div>
    </div>
</section>

<section id="blog" class="mt-4">
    <div class="container">
        <div class="row mt-5 gy-4 justify-content-center">
            <div class="col-lg-10">
                <div class="row mb-3">
                    <div class="col">
                        <h2>Update pembayaran</h2>
                    </div>
                    <div class="col text-end">
                        <a href="{{ url('pembayaran/transaksi' . '/' . $pembayaran->id) }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
                <form action="{{ url('/pembayaran/update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="siswa_id" value="{{ $pembayaran->id }}">
                    <input type="hidden" name="id" value="{{ $pembayaran->id }}">

                    <div class="form-group mb-2">
                        <label for="tanggal_bayar">Tanggal</label>
                        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control mb-2" value="{{ $pembayaran->tanggal_bayar }}" required />
                    </div>
                    <div class="form-group">
                        <label for="jumlah_bayar">Jumlah Bayar</label>
                        <input type="text" name="jumlah_bayar" id="jumlah_bayar" class="form-control @error('jumlah_bayar') is-invalid @enderror" value="{{ $pembayaran->jumlah_bayar }}" required>
                        @error('jumlah_bayar')
                            <div class="text-danger invalid feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
