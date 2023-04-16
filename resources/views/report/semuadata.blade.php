<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>

<body>
    <div class="container mt-3">
        <h2 class="text-center mt-4">Semua Data Pembayaran SPP Siswa</h2>
        <div class="row mt-1 gy-3 justify-content-center">
            <div class="col-lg-9">
                <table class="table table-striped table-bordered">
                    <thead align="center">
                        <th>No</th>
                        <th>Petugas</th>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>SPP</th>
                        <th>Jumlah Bayar</th>
                    </thead>
                    <tbody>
                        @if($cetakSemuaData->count() == 0)
                        <tr class="text-center">
                            <td colspan="5"><strong>Belum ada data.</strong></td>
                        </tr>
                        @else
                        @foreach ($cetakSemuaData as $cetak)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cetak->user->nama }}</td>
                            <td>{{ $cetak->siswa->user->nama }}</td>
                            <td>{{ $cetak->tanggal_bayar }}</td>
                            <td>{{ $cetak->spp->tahun }}</td>
                            <td>{{ 'Rp.' . $cetak->jumlah_bayar }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script type="text/javascript">
        window.print();
        
    </script>
</body>

</html>