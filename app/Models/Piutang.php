<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Piutang extends Model
{
    use HasFactory;

    protected $table = 'piutang';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $guard = ['id'];

    public static function totalSaldoPiutang()
    {
        $result = DB::table('saldo_piutang')->selectRaw('sum(if(pos=0, saldo, -saldo)) as saldo')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_piutang.id_pencatatan')
            ->whereNull('pencatatan.deleted_at')
            ->first()->saldo;

        return doubleval($result);
    }

    // FIXME: piutang per pelanggan
    public static function piutangPerPelanggan()
    {
        return DB::table('saldo_piutang')->selectRaw('pelanggan.nama as nama, pelanggan.id_pelanggan as id_pelanggan, sum(if(saldo_piutang.pos = 0, saldo_piutang.saldo, -saldo_piutang.saldo)) as saldo')
            ->leftJoin('piutang', 'piutang.id_piutang', '=', 'saldo_piutang.id_piutang')
            ->leftJoin('pelanggan', 'pelanggan.id_pelanggan', '=', 'piutang.id_pelanggan')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_piutang.id_pencatatan')
            ->whereNull('pencatatan.deleted_at')
            ->groupByRaw('piutang.id_pelanggan')
            ->get();
    }

    // FIXME: kenapa si saldo piutangnya masih tetap meskipun sudah dibayar 2000
    public static function piutangPelanggan($id_pelanggan)
    {
        return DB::table('saldo_piutang')->selectRaw('piutang.id_Piutang as id_piutang, pencatatan.created_at as tanggal, pencatatan.keterangan as keterangan, sum(if(pos = 0, saldo, -saldo)) as saldo')
            ->leftJoin('piutang', 'piutang.id_piutang', '=', 'saldo_piutang.id_piutang')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_piutang.id_pencatatan')
            ->leftJoin('pelanggan', 'pelanggan.id_pelanggan', '=', 'piutang.id_pelanggan')
            ->where('piutang.id_pelanggan', $id_pelanggan)
            ->whereNull('pencatatan.deleted_at')
            ->groupBy('piutang.id_piutang')
            ->get();
    }

    public static function saldoPiutang($id_piutang)
    {
        $saldo = DB::table('saldo_piutang')->selectRaw('sum(if(saldo_piutang.pos = 0, saldo_piutang.saldo, -saldo_piutang.saldo)) as saldo')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_piutang.id_pencatatan')
            ->leftJoin('piutang', 'piutang.id_piutang', '=', 'saldo_piutang.id_piutang')
            ->leftJoin('pelanggan', 'pelanggan.id_pelanggan', '=', 'piutang.id_pelanggan')
            ->whereNull('pencatatan.deleted_at')
            ->groupByRaw('piutang.id_piutang')
            ->where('piutang.id_piutang', '=', $id_piutang)
            ->first()->saldo;

        return floatval($saldo);
    }

    public static function pembayaranPiutang($data)
    {
        DB::transaction(function () use ($data) {
            $id_pencatatan = md5(uniqid(rand(), true));
            $id_kas = 'kas-' . md5(uniqid(rand(), true));

            DB::table('pencatatan')->insert([
                'id_pencatatan' => $id_pencatatan,
                'keterangan' => '[Pembayaran piutang]: ' . $data['keterangan'],
                'id_user' => $data['id_user'],
                'created_at' => $data['created_at'],
                'updated_at' => now(),
                'id_group_pencatatan' => 4,
            ]);

            DB::table('kas')->insert([
                'id_kas' => $id_kas,
                'id_pencatatan' => $id_pencatatan,
                'pos' => 1,
                'saldo' => $data['saldo'],
            ]);

            DB::table('saldo_piutang')->insert([
                'id_pencatatan' => $id_pencatatan,
                'id_piutang' => $data['id_piutang'],
                'pos' => 1,
                'saldo' => $data['saldo'],
            ]);
        });
    }

    public static function simpanData($data)
    {
        DB::transaction(function () use ($data) {
            $id_pencatatan = md5(uniqid(rand(), true));
            $id_piutang = 'rcv-' . md5(uniqid(rand(), true));
            DB::table('pencatatan')->insert([
                'id_pencatatan' => $id_pencatatan,
                'keterangan' => $data['keterangan'],
                'id_user' => $data['id_user'],
                'created_at' => $data['created_at'],
                'updated_at' => now(),
                'id_group_pencatatan' => 2,
            ]);

            DB::table('piutang')->insert([
                'id_piutang' => $id_piutang,
                'id_pencatatan' => $id_pencatatan,
                'id_pelanggan' => $data['id_pelanggan'],
            ]);

            DB::table('saldo_piutang')->insert([
                'id_pencatatan' => $id_pencatatan,
                'id_piutang' => $id_piutang,
                'pos' => 0,
                'saldo' => $data['saldo'],
            ]);
        });
    }

    public static function detailPembayaran($id_piutang)
    {
        return DB::table('saldo_piutang')->selectRaw('pencatatan.id_pencatatan as id_pencatatan, pencatatan.created_at as tanggal, pencatatan.keterangan as keterangan, saldo_piutang.id_piutang as id_piutang, pos, saldo')
            ->leftJoin('pencatatan', 'pencatatan.id_pencatatan', '=', 'saldo_piutang.id_pencatatan')
            ->leftJoin('piutang', 'piutang.id_piutang', '=', 'saldo_piutang.id_piutang')
            ->where('piutang.id_piutang', '=', $id_piutang)
            ->whereNull('pencatatan.deleted_at')
            ->get();
    }

    public static function getTanggalPencatatan($id_piutang)
    {
        return DB::table('piutang')->select('created_at as tanggal')
            ->join('pencatatan', 'pencatatan.id_pencatatan', '=', 'piutang.id_pencatatan')
            ->where('piutang.id_piutang', '=', $id_piutang)
            ->whereNull('pencatatan.deleted_at')
            ->first()->tanggal;
    }

    public function getRouteKeyName()
    {
        return 'id_piutang';
    }

    public function softDelete($id_pencatatan) // softDelete
    {
        // DB::table('pencatatan')
        // TODO: note todo yang ada di folder laravelProject folder materi file note
    }
}
