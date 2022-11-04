<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('karyawan.index', [
            'title' => 'Karyawan',
        ]);
    }

    public function dataKaryawan()
    {   // TODO: Lanjut untuk view daftar karyawan
        return response()->json([
            'data' => User::daftarKaryawan(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users', 'alpha_dash'],
            'no_telp' => ['required', 'max:30', 'alpha_num'],
            'password' => ['required', 'min:6', 'max:255', 'alpha_num'],
        ]);

        DB::table('users')->insert([
            'name' => $credentials['name'],
            'username' => $credentials['username'],
            'level' => 3,
            'password' => bcrypt($credentials['password']),
            'created_at' => now(),
            'updated_at' => now(),
            'no_telp' => $credentials['no_telp'],
        ]);

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(['data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $credentials = $request->validate([
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users,username,' . $user->id, 'alpha_dash'],
            'no_telp' => ['required', 'max:30', 'alpha_num'],
        ]);

        $user->update([
            'name' => $credentials['name'],
            'username' => $credentials['username'],
            'no_telp' => $credentials['no_telp'],
        ]);

        return response()->json([
            'success' => 'Data berhasil diubah',
        ]);
    }

    public function changePassword(Request $request, User $user)
    {
        $credentials = $request->validate([
            'password' => ['required', 'min:6', 'max:255', 'alpha_num'],
        ]);

        User::where('id', $user->id)->update([
            'password' => bcrypt($credentials['password']),
        ]);

        return response()->json(['data' => 'Password berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['data' => 'Data berhasil dihapus']);
    }

    

}
