<?php

namespace Database\Seeders;

use App\Models\Kas;
use App\Models\Pelanggan;
use App\Models\Pencatatan;
use App\Models\Piutang;
use App\Models\User;
use App\Models\Utang;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tester extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dump(config("constants.PEGAWAI"));
        // dump(Kas::tabelArusKas());
        // dump(date('Y-m-d H:i:s'));
        // $pelanggan = new Pelanggan();
        // dump(csrf_token());

        // dump(Piutang::saldoPiutang('rcv-479b66b611bb511b1776d13340b596c7'));
        // dump(Piutang::piutangPelanggan(19));
        // dump(Piutang::where('id_piutang', 'rcv-479b66b611bb511b1776d13340b596c7')->first());
        // dump(Piutang::getTanggalPencatatan('rcv-479b66b611bb511b1776d13340b596c7'));
        // TODO: Carbon error
        // rcv-a282f7323538a7c88b26ddcc5b8ab573
        // $date1 = Carbon::createFromFormat('Y-m-d H:i', '2022-08-31 21:21');
        // $date2 = Carbon::createFromFormat('Y-m-d H:i', '2022-09-31 21:21');
        // dump('2022-09-01 11:00' < '2022-09-01 11:00:01');
        // dump(Piutang::saldoPiutang('rcv-a282f7323538a7c88b26ddcc5b8ab573'));
        // dump(Piutang::piutangPerPelanggan());

        // dump(User::getKaryawan('steven_marulitua'));
        // dump(Kas::totalKas());
        // dump(Piutang::totalSaldoPiutang());
        dump(Pencatatan::getAll());
    }
}
