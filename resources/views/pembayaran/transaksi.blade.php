@extends('main.navbar')

@section('content')
<section id="hero" class="bg-dark py-5">
    <div class="container">
        <div class="text-center text-white">
            <h1>TRANSAKSI</h1>
            <h4>Transaksi SPP Siswa </h4>
        </div>
    </div>
</section>

<section id="blog" class="mt-4">
    <div class="container">
        <div class="row mt-5 gy-4 justify-content-center">
            <div class="col-lg-10">
                <div class="row mb-3">
                    <div class="col">
                        <h3>Transaksi SPP</h3>
                    </div>
                    <div class="col text-end">
                        <a href="{{ url('/pembayaran/tampil') }}" class="btn btn-warning">Back</a>
                        @cannot('siswa')
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tambah
                        </button>
                        @endcannot
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <div class="me-2"><b>NIS : {{ $siswa->nis }}</b></div>
            <div class="me-2"><b>Nama : {{ $siswa->user->nama }}</b></div>
            <div><b>Kelas : {{ $siswa->kelas->kelas }}</b></div>
        </div>
        <hr>
        <div class="d-flex justify-content-center text-center mt-4">
            <div class="card text-bg-success ms-5 me5 w-100">
                <div class="card-header">
                    <b>Total Dibayar</b>
                </div>
                <div class="card-body">
                    <h3>Rp. {{ $total['total_dibayar'] }}</h3>
                </div>
            </div>
            <div class="card text-bg-danger ms-5 me5 w-100">
                <div  class="card-header">
                    <b>Total Belum Dibayar</b>
                </div>
                <div class="card-body">
                    <h3>Rp. {{ $total['total_belumdibayar'] }}</h3>
                </div>
            </div>
        </div>
        <hr>
        @if(Session::has('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ Session::get('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
        @elseif(Session::has('gagal'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ Session::get('gagal') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <table class="table table-striped table-bordered mt-4">
            <thead align="center">
                <th>No</th>
                <th>Petugas</th>
                <th>Tanggal</th>
                <th>SPP</th>
                <th>Jumlah Bayar</th>
                @cannot('siswa')
                <th><i class="bi bi-gear-fill"></i></th>
                @endcannot
            </thead>
            <tbody>
                @if($pembayaran->count() == 0)
                <tr class="text-center">
                    <td colspan="6"><strong>Belum ada transaksi.</strong></td>
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
                            <a href="{{ url('/pembayaran/edit' . '/' . $data->id) }}" class="btn btn-sm btn-primary mb-1"><i class="bi bi-pencil-fill"></i> Edit</a>
                            <a href="{{ url('/pembayaran/destroy' . '/' . $data->id) }}" class="btn btn-sm btn-danger"><i class="bi bi-trash3-fill"></i> Hapus</a>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Transaksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('pembayaran/tambah') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                    <div class="form-group">
                        <label for="siswa">Petugas</label>
                        <input type="text" name="petugas" id="petugas" readonly value="{{ auth()->user()->nama }}" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="siswa">Siswa</label>
                        <input type="text" name="siswa" id="siswa" readonly value="{{ $siswa->user->nama }}" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="spp_id">SPP</label>
                        <select name="spp_id" id="spp_id" class="form-select" required>
                            <option value="" selected disabled>-Pilih SPP-</option>
                            @foreach($spp as $data)
                                @php $kurang = $data->nominal - $pembayaranSPP[$loop->iteration-1]; $kurangnya = "(Rp. $kurang)"  @endphp;
                                <option value="{{ $data->id }}" {{ $pembayaranSPP[$loop->iteration-1] >= $data->nominal ? 'disabled' : '' }} >{{ $data->tahun . ' - Rp. ' . $data->nominal}} {{ $pembayaranSPP[$loop->iteration-1] >= $data->nominal ? '(LUNAS)' : $kurangnya }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="tanggal_bayar">Tanggal</label>
                        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="jumlah_bayar">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control @error('jumlah_bayar') is-invalid @enderror" required>
                        @error('jumlah_bayar')
                            <div class="text-danger invalid feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

@endsection
<!-- @section('js')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        $(document).ready(function (){
           $('.btn-edit').on('click', function (e){
               var id = $(this).data('id');

               $.ajax({
                   type: 'POST',
                   url: "{{ url('api/pembayaran') }}",
                   data: {_token: "{{ csrf_token() }}", id: id},
                   success: function (data){
                       console.log(data)
                   }
               })
           })
        })
    </script>
@endsection -->

