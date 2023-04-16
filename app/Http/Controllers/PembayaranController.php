<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\User;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = null;

        if ($request->cari != null) {
            $siswa = Siswa::with('user')->whereRelation('user', 'nama', 'LIKE', "%$request->cari%")->orderBy('kelas_id', 'ASC')->get();
            $keyword = $request->cari;
        } else {
            $siswa = Siswa::orderBy('kelas_id', 'ASC')->get();
        }
        return view('pembayaran.index', compact('siswa', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transaksi($id)
    {
        $dibayar = 0;
        $tagihan = 0;
        $pembayaranSPP = [];

        try {
            $siswa = Siswa::findOrFail($id);
            $pembayaran = Pembayaran::where('siswa_id', $id)->get();
            $spp = Spp::all();

            foreach ($pembayaran as $data) {
                $dibayar += $data->jumlah_bayar;
            }

            foreach ($spp as $data) {
                $tagihan += $data->nominal;

                $total = Pembayaran::where('spp_id', $data->id)->where('siswa_id', $id)->sum('jumlah_bayar');
                $pembayaranSPP[] = $total;
            }

            $total = [
                'total_dibayar' => $dibayar,
                'total_belumdibayar' => $tagihan - $dibayar
            ];
        } catch (\Exception $e) {
            return redirect('pembayaran/tampil')->with('gagal', 'Data Tidak Ditemukan❌.');
        }

        return view('pembayaran.transaksi', compact('spp', 'pembayaran', 'siswa', 'total', 'pembayaranSPP'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        // try {
            $this->validate($request, [
                'jumlah_bayar' => 'required|numeric|min:0|not_in:0'
            ]); 

            $post = Pembayaran::create([
                'user_id' => auth()->user()->id,
                'siswa_id' => $request->siswa_id,
                'spp_id' => $request->spp_id,
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah_bayar' => $request->jumlah_bayar,
            ]);

            if($post) {
                return redirect()->back()->with('sukses', 'Transaksi berhasil diproses✔✔');
            } else {
                return redirect()->back()->withInput();
            }

        //     return redirect()->back()->with('sukses', 'Transaksi berhasil diproses✔✔');
        // } catch (\Exception $e) {
        //     return redirect()->back();
        //     $message = $e->getMessage();
        //     return redirect()->back()->with('gagal', 'Transaksi gagal diproses❌❌' . "{{ $message }}");
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            // $siswa = Siswa::findOrFail($id);
            // $pembayaran = Pembayaran::where('siswa_id', $id)->first();
            // $spp = Spp::all();

            $pembayaran = Pembayaran::findOrFail($id);
            $siswa = Siswa::all();
            $spp = Spp::all();
            $user = User::all();

            return view('pembayaran.edit', compact('pembayaran', 'siswa', 'spp'));
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect('pembayaran/transaksi' . '/' . $pembayaran->id)->with('gagal', 'Data Tidak Ditemukan❌.' . "($message)");
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        
        // try {

            $this->validate($request, [
                'jumlah_bayar' => 'required|numeric|min:0|not_in:0'
            ]); 
            
            $upd = Pembayaran::where('id', $request->id)->update([
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah_bayar' => $request->jumlah_bayar,
            ]);


            if($upd) {
                return redirect('pembayaran/transaksi' . '/' . $request->id)->with('sukses', 'Data Berhasil Diupdate✔✔');
            } else {
                return redirect()->back()->withInput();
            }
            

        //     return redirect('pembayaran/transaksi' . '/' . $request->id)->with('sukses', 'Data Berhasil Diupdate✔✔');
        // } catch (\Exception $e) {
        //     $message = $e->getMessage();
        //     return redirect('pembayaran/transaksi' . '/' . $request->id)->with('gagal', 'Data Gagal Diupdate❌❌' . "($message)");
        // }
    }

    //API Functions
    //-- Get Pembayaran by Id

    // public function getPembayaran(Request $request){
    //     try {
    //         $pembayaran = Pembayaran::where('id', $request->id)->first();

    //         return response()->json($pembayaran);
    //     }catch (\Exception $e){
    //         return response()->json(['error' => 'Data yang anda minta tidak ada! ❌']);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            Pembayaran::destroy($pembayaran->id);
            Siswa::destroy($pembayaran->jumlah_bayar);

            return redirect()->back()->with('sukses', 'Data Berhasil Dihapus✔✔');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Data Gagal Dihapus❌❌');
        }
    }


    public function historyPembayaranSiswa()
    {
        try {

            $user_id = auth()->user()->id;
            $siswa = Siswa::where('user_id', $user_id)->first();
            $pembayaran = Pembayaran::where('siswa_id', $siswa->id)->get();

            return view('pembayaran.historypembayaran', compact('pembayaran', 'siswa'));
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    public function semuaData(Request $request)
    {

        $cetakSemuaData =  Pembayaran::with('siswa')->get();
        return view('report.semuadata', compact('cetakSemuaData'));
    }

    public function dataPerSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $cetakDataPerSiswa = Pembayaran::where('siswa_id', $id)->get();
        return view('report.datapersiswa', compact('cetakDataPerSiswa', 'siswa'));
    }
}
