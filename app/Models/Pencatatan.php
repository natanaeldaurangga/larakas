<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pencatatan extends Model
{
    use HasFactory;

    protected $table = 'pencatatan';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $guard = ['id'];

    public function getRouteKeyName()
    {
        return 'id_pencatatan';
    }

    public function setDeletedAt(bool $arg)
    {
        DB::table($this->table)->where('id_pencatatan', $this->id_pencatatan)->update([
            'deleted_at' => $arg ? now() : null,
        ]);
    }

    public function softDelete()
    {
        $this->setDeletedAt(true);
    }

    public function restore()
    {
        $this->setDeletedAt(false);
    }

    public function getIdPencatatan()
    {
        return $this->id_pencatatan;
    }

    public static function getAll()
    {
        return DB::table('pencatatan')->selectRaw('id_pencatatan, keterangan, id_user, users.name as user, pencatatan.created_at as created_at, pencatatan.updated_at as updated_at, pencatatan.deleted_at as deleted_at, id_group_pencatatan, group_pencatatan.nama as group_pencatatan')
            ->join('users', 'users.id', '=', 'pencatatan.id_user')
            ->join('group_pencatatan', 'group_pencatatan.id', '=', 'pencatatan.id_group_pencatatan')
            ->whereNotNull('pencatatan.deleted_at')
            ->get();
    }
}
