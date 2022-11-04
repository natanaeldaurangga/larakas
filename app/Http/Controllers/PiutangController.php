<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pencatatan;
use App\Models\Piutang;
use App\Rules\DateRule;
use App\Rules\SaldoRule;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Lanjut untuk halaman index piutang
        return view('pencatatan.piutang.index', [
            'title' => 'Data Piutang',
            'pelanggan' => Pelanggan::all(),
        ]);
    }

    public function pagePiutangPelanggan(Pelanggan $pelanggan)
    {
        return view('pencatatan.piutang.detailPiutang', [
            'title' => 'Data Piutang ' . $pelanggan->nama,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function piutangPerPelanggan()
    {
        return response()->json([
            'data' => Piutang::piutangPerPelanggan(),
        ]);
    }

    public function piutangPelanggan(Pelanggan $pelanggan)
    {
        return response()->json([
            'data' => Piutang::piutangPelanggan($pelanggan->id_pelanggan),
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
            'id_pelanggan' => 'required|exists:pelanggan',
            'saldo' => 'required|numeric|gte:0',
        ]);

        $credentials['id_user'] = auth()->user()->id;

        Piutang::simpanData($credentials);
        return response()->json(['success' => 'Transaksi berhasil dicatat']);
    }

    public function pembayaran(Request $request, Piutang $piutang)
    {
        // TODO: Lanjut untuk ngamil tanggal pencatatan piutang untuk dijadikan batas bawah dari tanggal pembayaran piutang
        // $piutang = Piutang::where('id_piutang', $request->id_piutang);
        $credentials = $request->validate([
            'created_at' => ['required', 'date', 'date_format:Y-m-d H:i', 'before:tomorrow', new DateRule(Piutang::getTanggalPencatatan($piutang->id_piutang), '<=')],
            'keterangan' => '',
            'id_piutang' => 'required|exists:piutang',
            'saldo' => [new SaldoRule($piutang->id_piutang, 'piutang')],
        ]);

        $credentials['id_user'] = auth()->user()->id;

        // TODO: piutang berhasil dicatat, lanjut untuk utang
        Piutang::pembayaranPiutang($credentials);

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    public function pageDetailPembayaran(Piutang $piutang)
    {
        $view = view('pencatatan.piutang.detailPembayaran', [
            'title' => 'Riwayat Pembayaran',
            'piutang' => $piutang,
            'sisa_saldo' => Piutang::saldoPiutang($piutang->id_piutang),
            'pelanggan' => Pelanggan::where('id_pelanggan', $piutang->id_pelanggan)->first(),
        ]);

        return $view;
    }

    public function detailPembayaran(Piutang $piutang)
    {
        return response()->json([
            'data' => Piutang::detailPembayaran($piutang->id_piutang),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Piutang  $piutang
     * @return \Illuminate\Http\Response
     */
    public function show(Piutang $piutang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Piutang  $piutang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Piutang $piutang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Piutang  $piutang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Piutang $piutang)
    {
        //
    }

    public function softDelete(Pencatatan $pencatatan)
    {
        $pencatatan->softDelete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
