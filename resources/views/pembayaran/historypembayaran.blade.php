@extends('main.navbar')
@section('content')
<section id="hero" class="bg-dark py-5">
    <div class="container">
        <div class="text-center text-white">
            <h1>History Pembayaran</h1>
        </div>
    </div>
</section>

<section id="blog" class="mt-4">
    <div class="container">
        <div class="row mt-5 gy-4 justify-content-center">
            <div class="col-lg-10">
                <div class="row mb-3">
                    <div class="col">
                        <h3>History Pembayaran</h3>
                    </div>
                    <div class="col text-end">
                        <a href="{{ url('/dashboard') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered mt-4">
            <thead align="center">
            <th>No</th>
            <th>Petugas</th>
            <th>Tanggal</th>
            <th>SPP</th>
            <th>Jumlah Bayar</th>
            </thead>
            <tbody>
            @if($pembayaran->count() == 0)
                <tr class="text-center">
                    <td colspan="6"><strong>Belum ada history pembayaran.</strong></td>
                </tr>
            @else
                @foreach ($pembayaran as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->user->nama }}</td>
                        <td>{{ $data->tanggal_bayar }}</td>
                        <td>{{ $data->spp->tahun }}</td>
                        <td>{{ 'Rp.' . $data->jumlah_bayar }}</td>
                        @cannot('siswa')
                        <td>
                            <div class="d-grid">
                                <button data-id="{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#modalEdit" class="btn btn-primary btn-sm btn-edit">Edit</button>
                                <button data-id="{{ $data->id }}" class="btn btn-danger btn-sm">Hapus</button>
                            </div>
                        </td>
                        @endcannot
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</section>
@endsection