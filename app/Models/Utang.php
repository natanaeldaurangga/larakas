<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utang extends Model
{
    use HasFactory;

    protected $table = 'utang';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $guard = ['id'];

    public static function totalSaldoUtang()
    {
        $result = DB::table('saldo_utang')->selectRaw('sum(if(pos=0, saldo, -saldo)) as saldo')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_utang.id_pencatatan')
            ->whereNull('pencatatan.deleted_at')
            ->first()->saldo;

        return doubleval($result);
    }

    public static function utangPerPemasok()
    {
        return DB::table('saldo_utang')->selectRaw('pemasok.nama as nama, pemasok.id_pemasok as id_pemasok, sum(if(saldo_utang.pos = 0, saldo_utang.saldo, -saldo_utang.saldo)) as saldo')
            ->leftJoin('utang', 'utang.id_utang', '=', 'saldo_utang.id_utang')
            ->leftJoin('pemasok', 'pemasok.id_pemasok', '=', 'utang.id_pemasok')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_utang.id_pencatatan')
            ->whereNull('pencatatan.deleted_at')
            ->groupByRaw('utang.id_pemasok')
            ->get();
    }

    // FIXME: kenapa si saldo utangnya masih tetap meskipun sudah dibayar 2000
    public static function utangPemasok($id_pemasok)
    {
        return DB::table('saldo_utang')->selectRaw('utang.id_utang as id_utang, pencatatan.created_at as tanggal, pencatatan.keterangan as keterangan, sum(if(pos = 0, saldo, -saldo)) as saldo')
            ->leftJoin('utang', 'utang.id_utang', '=', 'saldo_utang.id_utang')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_utang.id_pencatatan')
            ->leftJoin('pemasok', 'pemasok.id_pemasok', '=', 'utang.id_pemasok')
            ->where('utang.id_pemasok', $id_pemasok)
            ->whereNull('pencatatan.deleted_at')
            ->groupBy('utang.id_utang')
            ->get();
    }

    public static function saldoUtang($id_utang)
    {
        $saldo = DB::table('saldo_utang')->selectRaw('sum(if(saldo_utang.pos = 0, saldo_utang.saldo, -saldo_utang.saldo)) as saldo')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_utang.id_pencatatan')
            ->leftJoin('utang', 'utang.id_utang', '=', 'saldo_utang.id_utang')
            ->leftJoin('pemasok', 'pemasok.id_pemasok', '=', 'utang.id_pemasok')
            ->whereNull('pencatatan.deleted_at')
            ->groupByRaw('utang.id_utang')
            ->where('utang.id_utang', '=', $id_utang)
            ->first()->saldo;

        return floatval($saldo);
    }

    public static function pembayaranUtang($data)
    {
        DB::transaction(function () use ($data) {
            $id_pencatatan = md5(uniqid(rand(), true));
            $id_kas = 'kas-' . md5(uniqid(rand(), true));

            DB::table('pencatatan')->insert([
                'id_pencatatan' => $id_pencatatan,
                'keterangan' => '[Pembayaran utang]: ' . $data['keterangan'],
                'id_user' => $data['id_user'],
                'created_at' => $data['created_at'],
                'updated_at' => now(),
                'id_group_pencatatan' => 5,
            ]);

            DB::table('kas')->insert([
                'id_kas' => $id_kas,
                'id_pencatatan' => $id_pencatatan,
                'pos' => 0,
                'saldo' => $data['saldo'],
            ]);

            DB::table('saldo_utang')->insert([
                'id_pencatatan' => $id_pencatatan,
                'id_utang' => $data['id_utang'],
                'pos' => 1,
                'saldo' => $data['saldo'],
            ]);
        });
    }

    public static function simpanData($data)
    {
        DB::transaction(function () use ($data) {
            $id_pencatatan = md5(uniqid(rand(), true));
            $id_utang = 'pyb-' . md5(uniqid(rand(), true));
            DB::table('pencatatan')->insert([
                'id_pencatatan' => $id_pencatatan,
                'keterangan' => $data['keterangan'],
                'id_user' => $data['id_user'],
                'created_at' => $data['created_at'],
                'updated_at' => now(),
                'id_group_pencatatan' => 3,
            ]);

            DB::table('utang')->insert([
                'id_utang' => $id_utang,
                'id_pencatatan' => $id_pencatatan,
                'id_pemasok' => $data['id_pemasok'],
            ]);

            DB::table('saldo_utang')->insert([
                'id_pencatatan' => $id_pencatatan,
                'id_utang' => $id_utang,
                'pos' => 0,
                'saldo' => $data['saldo'],
            ]);
        });
    }

    public static function detailPembayaran($id_utang)
    {
        return DB::table('saldo_utang')->selectRaw('pencatatan.id_pencatatan as id_pencatatan, pencatatan.created_at as tanggal, pencatatan.keterangan as keterangan, saldo_utang.id_utang as id_utang, pos, saldo')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_utang.id_pencatatan')
            ->leftJoin('utang', 'utang.id_utang', '=', 'saldo_utang.id_utang')
            ->where('utang.id_utang', '=', $id_utang)
            ->whereNull('pencatatan.deleted_at')
            ->get();
    }

    public static function getTanggalPencatatan($id_utang)
    {
        return DB::table('utang')->select('created_at as tanggal')
            ->join('pencatatan', 'pencatatan.id_pencatatan', '=', 'utang.id_pencatatan')
            ->where('utang.id_utang', '=', $id_utang)
            ->whereNull('pencatatan.deleted_at')
            ->first()->tanggal;
    }

    public function getRouteKeyName()
    {
        return 'id_utang';
    }

    public function softDelete($id_pencatatan) // softDelete
    {
        // TODO: saya rasa proyek ini sudah beres jadi... kita lanjut saja ke spring
    }
}
