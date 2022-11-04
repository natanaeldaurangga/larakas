<?php

namespace Database\Seeders;

use App\Models\Pemasok;
use App\Models\utang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UtangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id_pemasok = DB::table('pemasok')->pluck('id_pemasok')->toArray();
        $id_user = DB::table('users')->pluck('id')->toArray();

        $daftar_utang = [100_000, 50_000, 70_000, 200_000, 500_000, 1_000_000];
        for ($i = 0; $i < 3; $i++) {
            $rand_id = $id_pemasok[array_rand($id_pemasok)];
            $rand_user = $id_user[array_rand($id_user)];
            $rand_money = $daftar_utang[array_rand($daftar_utang)];
            Utang::simpanData([
                'created_at' => now(),
                'id_user' => $rand_user,
                'id_pemasok' => $rand_id,
                'pos' => 0,
                'saldo' => $rand_money,
                'keterangan' => '',
            ]);
        }
    }
}
