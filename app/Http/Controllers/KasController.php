<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pencatatan.kas.index', [
            'title' => 'Arus Kas',
        ]);
    }

    public function arusKas()
    {
        $response = [
            'data' => Kas::tabelArusKas(),
            'hello' => 'test',
        ];

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pencatatan.kas.create', [
            'title' => 'Catat Kas',
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
            'created_at' => 'required|date|date_format:Y-m-d H:i|before:tomorrow',
            'pos' =>  ['required', 'in:0,1'],
            'saldo' => 'required|numeric|gte:0',
            'keterangan' => '',
        ]);

        // dd($validatedData);
        Kas::catatKas($validatedData);
        return redirect('/kas')->with('success', 'Kas telah dicatat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function show(Kas $kas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pencatatan Kas',
            'kas' => Kas::dataKas($id),
        ];

        return view('pencatatan.kas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id_kas' => 'required',
            'id_pencatatan' => 'required',
            'created_at' => ['required', 'date', 'date_format:Y-m-d H:i:s,Y-m-d H:i', 'before:tomorrow'],
            'pos' =>  ['required', 'in:0,1'],
            'saldo' => 'required|numeric|gte:0',
            'keterangan' => '',
        ]);

        // dd($validatedData);
        Kas::updatePencatatan($validatedData);
        return redirect('/kas')->with('success', 'Kas telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pencatatan)
    {
        Kas::softDeletePencatatan($id_pencatatan);
        return redirect('/kas')->with('success', 'Kas telah dihapus');
    }
}
