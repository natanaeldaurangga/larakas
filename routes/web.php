<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\LoginContronller;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\utangController;
use App\Models\Pencatatan;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(LoginContronller::class)->group(function () {
    Route::get('/', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'authenticate')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    // untuk dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index');
    });

    Route::resources([
        'kas' => KasController::class,
        'pelanggan' => PelangganController::class,
        'pemasok' => PemasokController::class,
        'piutang' => PiutangController::class,
        'pencatatan' => Pencatatan::class,
        'utang' => UtangController::class,
        // 'karyawan' => KaryawanController::class,
    ]);

    Route::resource('karyawan', KaryawanController::class)->parameter('karyawan', 'user')->middleware('admin');
    Route::resource('pencatatan', PencatatanController::class)->middleware('admin');

    // TODO: Lanjut pemasok, pelanggan, utang, piutang
    // JSON request
    Route::get('/arus-kas', [KasController::class, 'arusKas']);
    Route::get('/data-pelanggan', [PelangganController::class, 'dataPelanggan']);
    Route::get('/data-pemasok', [PemasokController::class, 'dataPemasok']);

    // Piutang
    Route::get('/data-piutang', [PiutangController::class, 'piutangPerPelanggan']);
    Route::get('/piutang-pelanggan/{pelanggan}', [PiutangController::class, 'pagePiutangPelanggan']);
    Route::get('/data-piutang-pelanggan/{pelanggan}', [PiutangController::class, 'piutangPelanggan']);
    Route::put('/pembayaran-piutang/{piutang:id_piutang}', [PiutangController::class, 'pembayaran']);
    Route::get('/page-detail-pembayaran-piutang/{piutang:id_piutang}', [PiutangController::class, 'pageDetailPembayaran']);
    Route::get('/detail-pembayaran-piutang/{piutang:id_piutang}', [PiutangController::class, 'detailPembayaran']);
    Route::delete('/hapus-piutang/{pencatatan:id_pencatatan}', [PiutangController::class, 'softDelete']);
    Route::get('/data-utang', [UtangController::class, 'utangPerPemasok']);
    Route::get('/utang-pemasok/{pemasok}', [utangController::class, 'pageUtangPemasok']);
    Route::get('/data-utang-pemasok/{pemasok}', [UtangController::class, 'utangPemasok']);
    Route::put('/pembayaran-utang/{utang:id_utang}', [UtangController::class, 'pembayaran']);
    Route::get('/page-detail-pembayaran-utang/{utang:id_utang}', [UtangController::class, 'pageDetailPembayaran']);
    Route::get('/detail-pembayaran-utang/{utang:id_utang}', [UtangController::class, 'detailPembayaran']);
    Route::delete('/hapus-utang/{pencatatan:id_pencatatan}', [UtangController::class, 'softDelete']);
    Route::get('/data-karyawan', [KaryawanController::class, 'dataKaryawan']);
    Route::put('/change-password-karyawan/{user:username}', [KaryawanController::class, 'changePassword']);
    Route::get('/riwayat-pencatatan', [PencatatanController::class, 'riwayatPencatatan']);
    Route::put('/restore-pencatatan/{pencatatan:id_pencatatan}', [PencatatanController::class, 'restore']);
    Route::delete('/delete-pencatatan/{pencatatan:id_pencatatan}', [PencatatanController::class, 'permanentDelete']);
});

Route::resources([]);

// route untuk debugging
// FIXME: Hapus kalo udah production
Route::get('/clear', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});
