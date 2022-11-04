<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $primaryKey = 'id_pelanggan';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $guard = ['id_pelanggan'];

    protected $fillable = ['nama', 'no_telp', 'alamat'];

    public static function simpanData($data)
    {
        DB::table('pelanggan')->insert([
            'nama' => $data['nama'],
            'no_telp' => $data['no_telp'],
            'alamat' => $data['alamat'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }



    public static function perbaruiData($id, $data)
    {
        DB::table('pelanggan')->where('id_pelanggan', $id)->update($data);
    }

    public static function hapusData($id)
    {
        DB::table('pelanggan')->where('id_pelanggan', $id)->delete();
    }
}
