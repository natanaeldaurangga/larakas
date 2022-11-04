<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemasok extends Model
{
    use HasFactory;

    protected $table = 'pemasok';

    protected $primaryKey = 'id_pemasok';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $guard = ['id_pemasok'];

    protected $fillable = ['nama', 'no_telp', 'alamat'];

    public static function simpanData($data)
    {
        DB::table('pemasok')->insert([
            'nama' => $data['nama'],
            'no_telp' => $data['no_telp'],
            'alamat' => $data['alamat'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function perbaruiData($id, $data)
    {
        DB::table('pemasok')->where('id_pemasok', $id)->update($data);
    }

    public static function hapusData($id)
    {
        DB::table('pemasok')->where('id_pemasok', $id)->delete();
    }
}
