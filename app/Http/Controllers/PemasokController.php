<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pemasok.index', [
            'title' => 'Pemasok'
        ]);
    }

    public function dataPemasok()
    {
        return response()->json([
            'data' => Pemasok::all()
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
        $validatedData = $request->validate([
            'nama' => 'required',
            'no_telp' => 'unique:pemasok',
            'alamat' => '',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'no_telp.unique' => 'Nomor Telepon sudah terdaftar',
        ]);

        Pemasok::simpanData($validatedData);
        return response()->json(['success' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function show(Pemasok $pemasok)
    {
        return response()->json(['data' => $pemasok]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemasok $pemasok)
    {
        $rules = [
            'nama' => 'required',
            'no_telp' => 'unique:pemasok',
            'alamat' => '',
        ];

        if ($request->no_telp == $pemasok->no_telp) {
            $rules['no_telp'] = '';
        }

        $validatedData = $request->validate($rules);

        Pemasok::perbaruiData($pemasok->id_pemasok, $validatedData);
        return response()->json(['success' => 'Data berhasil diperbarui']);
    }

    // TODO: Lanjut ke utang, piutang
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
