<?php

namespace App\Http\Controllers;

use App\Models\Pencatatan;
use Illuminate\Http\Request;

class PencatatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [
            'title' => 'Riwayat Pencatatan'
        ]);
    }

    public function riwayatPencatatan()
    {
        return response()->json([
            'data' => Pencatatan::getAll(),
        ]);
    }

    public function restore(Pencatatan $pencatatan)
    {
        // return response()->json([
        //     'data' => $pencatatan
        // ]);
        $pencatatan->restore();
        return response()->json([
            'data' => 'Pencatatan berhasil dipulihkan',
        ]);
    }

    public function permanentDelete(Pencatatan $pencatatan)
    {
        $pencatatan->delete();
        return response()->json([
            'data' => 'Riwayat pencatatan berhasil dihapus',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pencatatan  $pencatatan
     * @return \Illuminate\Http\Response
     */
    public function show(Pencatatan $pencatatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pencatatan  $pencatatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pencatatan $pencatatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pencatatan  $pencatatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pencatatan $pencatatan)
    {
        //
    }
}
