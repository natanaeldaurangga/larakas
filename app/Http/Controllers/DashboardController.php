<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Piutang;
use App\Models\Utang;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'title' => 'Home',
            'total_kas' => Kas::totalKas(),
            'total_piutang' => Piutang::totalSaldoPiutang(),
            'total_utang' => Utang::totalSaldoUtang()
        ]);
        // TODO: Lanjut untuk laporan keuangan
    }
}
