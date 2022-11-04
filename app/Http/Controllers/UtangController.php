<?php

namespace App\Http\Controllers;

use App\Models\pemasok;
use App\Models\Pencatatan;
use App\Models\utang;
use App\Rules\DateRule;
use App\Rules\SaldoRule;
use Illuminate\Http\Request;

class utangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Lanjut untuk halaman index utang
        return view('pencatatan.utang.index', [
            'title' => 'Data utang',
            'pemasok' => pemasok::all(),
        ]);
    }

    public function pageUtangPemasok(Pemasok $pemasok)
    {
        return view('pencatatan.utang.detailUtang', [
            'title' => 'Data Utang ' . $pemasok->nama,
            'pemasok' => $pemasok,
        ]);
    }

    public function utangPerPemasok()
    {
        return response()->json([
            'data' => Utang::utangPerPemasok(),
        ]);
    }

    public function utangPemasok(Pemasok $pemasok)
    {
        return response()->json([
            'data' => Utang::utangPemasok($pemasok->id_pemasok),
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
        $credentials = $request->validate([
            'created_at' => 'required|date|date_format:Y-m-d H:i|before:tomorrow',
            'keterangan' => '',
            'id_pemasok' => 'required|exists:pemasok',
            'saldo' => 'required|numeric|gte:0',
        ]);

        $credentials['id_user'] = auth()->user()->id;

        Utang::simpanData($credentials);
        return response()->json(['success' => 'Transaksi berhasil dicatat']);
    }

    public function pembayaran(Request $request, Utang $utang)
    {
        // TODO: Lanjut untuk ngamil tanggal pencatatan utang untuk dijadikan batas bawah dari tanggal pembayaran utang
        // $utang = Utang::where('id_utang', $request->id_utang);
        $credentials = $request->validate([
            'created_at' => ['required', 'date', 'date_format:Y-m-d H:i', 'before:tomorrow', new DateRule(Utang::getTanggalPencatatan($utang->id_utang), '<=')],
            'keterangan' => '',
            'id_utang' => 'required|exists:utang',
            'saldo' => [new SaldoRule($utang->id_utang, 'utang')],
        ]);

        $credentials['id_user'] = auth()->user()->id;

        // TODO: utang berhasil dicatat, lanjut untuk utang
        Utang::pembayaranutang($credentials);

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    public function pageDetailPembayaran(Utang $utang)
    {
        $view = view('pencatatan.utang.detailPembayaran', [
            'title' => 'Riwayat Pembayaran',
            'utang' => $utang,
            'sisa_saldo' => Utang::saldoUtang($utang->id_utang),
            'pemasok' => pemasok::where('id_pemasok', $utang->id_pemasok)->first(),
        ]);

        return $view;
    }

    public function detailPembayaran(Utang $utang)
    {
        return response()->json([
            'data' => Utang::detailPembayaran($utang->id_utang),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\utang  $utang
     * @return \Illuminate\Http\Response
     */
    public function show(Utang $utang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\utang  $utang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, utang $utang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\utang  $utang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Utang $utang)
    {
        //
    }

    public function softDelete(Pencatatan $pencatatan)
    {
        $pencatatan->softDelete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
