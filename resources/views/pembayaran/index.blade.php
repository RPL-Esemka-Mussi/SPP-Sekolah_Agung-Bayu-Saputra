@extends('main.navbar')

@section('content')
<section id="hero" class="bg-dark py-5">
    <div class="container">
        <div class="text-center text-white">
            <h1>PEMBAYARAN</h1>
            <h4>Kelola Pembayaran Spp Siswa</h4>
        </div>
    </div>
</section>

<div class="container mt-5">
    <div class="d-flex justify-content-around">
        <div>
            <h4>Data Pembayaran</h4>
        </div>
        <form class="row row-cols-lg-auto g-1 align-items-center" action="{{ url('pembayaran/tampil') }}" method="GET">
            <div class="col-12">
                <input type="text" name="cari" id="cari" value="{{ $keyword != null ? $keyword : '' }}" class="form-control" placeholder="cari data...">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success ms-3"><i class="bi bi-search"></i> Cari</button>
                @can('admin')
                <a href="{{ url('cetak/semuadata') }}" class="btn btn-secondary ms-2">Cetak Semua</a>
                @endcan
            </div>
        </form>
    </div>
    <div class="row mt-1 gy-3 justify-content-center">
        <div class="col-lg-9">
            <table class="table table-striped table-bordered">
                <thead align="center">
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th><i class="bi bi-gear-fill"></i></th>
                </thead>
                <tbody>
                    @if($siswa->count() == 0)
                    <tr class="text-center">
                        <td colspan="5"><strong>Belum ada data.</strong></td>
                    </tr>
                    @else
                    @foreach ($siswa as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nis }}</td>
                        <td>{{ $data->user->nama }}</td>
                        <td>{{ $data->kelas->kelas }}</td>
                        <td>
                            <div class="d-grid">
                                <a href="{{ '/pembayaran/transaksi' . '/' . $data->id }}" class="btn btn-sm btn-primary mb-1">Transaksi</a>
                            </div>
                            @can('admin')
                            <div class="d-grid">
                                <a href="{{ url('/cetak/datapersiswa' . '/' . $data->id) }}" class="btn btn-sm btn-secondary mt-1">Cetak</a>
                            </div>
                            @endcan
                            <!-- @can('siswa')
                            <div class="d-grid">
                                <a href="{{ '/pembayaran/history'}}" class="btn btn-sm btn-primary mb-1">Histori</a>
                            </div>
                            @endcan -->
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection