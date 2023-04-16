<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Spp;
use App\Models\User;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::with('user', 'kelas')->get();
        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $kelas = Kelas::all();
        $spp = Spp::all();
        return view('siswa.create', [
            'user' => $user,
            'kelas' => $kelas,
            'spp' => $spp,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'level' => 'siswa'
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'kelas_id' => $request->kelas,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ]);

            return redirect('siswa/tampil')->with('sukses', 'Data Berhasil Ditambahkan✔✔');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect('siswa/tampil')->with('gagal', 'Data Gagal Ditambahkan❌❌' . "($message)");
        }
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
            $siswa = Siswa::findOrFail($id);
            $kelas = Kelas::all();

            return view('siswa.edit', compact('siswa', 'kelas'));
        } catch (\Exception $e) {
            return redirect('siswa/tampil')->with('gagal', 'Data Tidak Ditemukan❌.');
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
        try {

            $siswa = Siswa::findOrFail($request->id);

            if ($request->password != null) {
                User::where('id', $siswa->user_id)->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
            } else {
                User::where('id', $siswa->user_id)->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                ]);
            }

            Siswa::where('id', $request->id)->update([
                'nis' => $request->nis,
                'kelas_id' => $request->kelas,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ]);

            return redirect('siswa/tampil')->with('sukses', 'Data Berhasil Diupdate✔✔');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect('siswa/tampil')->with('gagal', 'Data Gagal Diupdate❌❌' . "($message)");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            Siswa::destroy($siswa->id);
            User::destroy($siswa->user_id);

            return redirect('siswa/tampil')->with('sukses', 'Data Berhasil Dihapus✔✔');
        } catch (\Exception $e) {
            return redirect('siswa/tampil')->with('gagal', 'Data Gagal Dihapus❌❌');
        }
    }
}
