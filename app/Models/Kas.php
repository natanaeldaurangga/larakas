<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'kas';

    protected $primaryKey = 'id_kas';

    protected $keyType = 'string';

    public $incrementing = false;

    public static function totalKas()
    {
        $result = DB::table('kas')->selectRaw('sum(if(pos=1,saldo, -saldo)) as saldo')
            ->join('pencatatan', 'kas.id_pencatatan', '=', 'pencatatan.id_pencatatan')
            ->whereNull('pencatatan.deleted_at')
            ->first()->saldo;

        return doubleval($result);
    }

    public static function tabelArusKas()
    {
        return DB::table('kas')
            ->join('pencatatan', 'kas.id_pencatatan', '=', 'pencatatan.id_pencatatan')
            ->whereNull('pencatatan.deleted_at')
            ->orderBy('pencatatan.created_at', 'desc')
            ->get();
    }

    public static function dataKas($id_kas)
    {
        return DB::table('kas')
            ->join('pencatatan', 'kas.id_pencatatan', '=', 'pencatatan.id_pencatatan')
            ->whereNull('pencatatan.deleted_at')
            ->where('id_kas', '=', $id_kas)
            ->get()->first();
    }

    public static function catatKas($data)
    {
        DB::transaction(function () use ($data) {
            $id_pencatatan = md5(uniqid(rand(), true));
            $id_kas = 'kas-' . md5(uniqid(rand(), true));
            DB::table('pencatatan')->insert([
                'id_pencatatan' => $id_pencatatan,
                'created_at' => $data['created_at'],
                'keterangan' => $data['keterangan'],
                'updated_at' => now(),
                'id_user' => auth()->user()->id,
                'id_group_pencatatan' => 1, // 1 adalah id untuk transaksi kas
            ]);

            DB::table('kas')->insert([
                'id_kas' => $id_kas,
                'id_pencatatan' => $id_pencatatan,
                'pos' => $data['pos'],
                'saldo' => $data['saldo'],
            ]);
        });
    }

    public static function softDeletePencatatan($id_pencatatan)
    {
        DB::table('pencatatan')->where('id_pencatatan', $id_pencatatan)->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
    }

    public static function forceDeletePencatatan($id_pencatatan)
    {
        DB::table('pencatatan')->where('id_pencatatan', $id_pencatatan)->delete();
    }

    public function getRouteKeyName()
    {
        return 'id_kas';
    }

    public static function updatePencatatan($data)
    {
        DB::transaction(function () use ($data) {
            DB::table('pencatatan')
                ->where('id_pencatatan', $data['id_pencatatan'])
                ->update([
                    'keterangan' => $data['keterangan'],
                    'created_at' => $data['created_at'],
                    'updated_at' => now(),
                ]);

            DB::table('kas')
                ->where('id_pencatatan', $data['id_pencatatan'])
                ->update([
                    'pos' => $data['pos'],
                    'saldo' => $data['saldo']
                ]);
        });
    }
}
