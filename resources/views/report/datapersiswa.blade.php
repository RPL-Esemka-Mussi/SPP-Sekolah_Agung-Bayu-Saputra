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
        <h2 class="text-center mt-4"> Data Pembayaran SPP Siswa</h2>
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
                        @if($cetakDataPerSiswa->count() == 0)
                        <tr class="text-center">
                            <td colspan="5"><strong>Belum ada data.</strong></td>
                        </tr>
                        @else
                        @foreach ($cetakDataPerSiswa as $cetakData)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cetakData->user->nama }}</td>
                            <td>{{ $cetakData->siswa->user->nama }}</td>
                            <td>{{ $cetakData->tanggal_bayar }}</td>
                            <td>{{ $cetakData->spp->tahun }}</td>
                            <td>{{ 'Rp.' . $cetakData->jumlah_bayar }}</td>
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