<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('pelanggan.index', [
            'title' => 'Pelanggan',
        ]);
    }

    public function dataPelanggan()
    {
        return response()->json([
            'data' => Pelanggan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('pelanggan.create', [
        //     'title' => 'Tambah Pelanggan',
        // ]);
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
            'no_telp' => 'unique:pelanggan',
            'alamat' => '',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'no_telp.unique' => 'Nomor Telepon sudah terdaftar',
        ]);

        Pelanggan::simpanData($validatedData);
        return response()->json(['success' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        return response()->json(["data" => $pelanggan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $rules = [
            'nama' => 'required',
            'no_telp' => 'unique:pelanggan',
            'alamat' => '',
        ];

        if ($request->no_telp == $pelanggan->no_telp) {
            $rules['no_telp'] = '';
        }

        $validatedData = $request->validate($rules);

        Pelanggan::perbaruiData($pelanggan->id_pelanggan, $validatedData);
        return response()->json(['success' => 'Data berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan) // TODO: Lanjut untuk pemasok
    {
        $pelanggan->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
