<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Psr\Log\LogLevel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // TODO: Lanjut dari sini
        // DB::table('users')->insert(
        //     [
        //         'name' => 'Natanael Daurangga',
        //         'username' => 'natanael_daurangga',
        //         'level' => 1,
        //         'password' => bcrypt('12345'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Steven Marulitua',
        //         'username' => 'steven_marulitua',
        //         'level' => 2,
        //         'password' => bcrypt('12345'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // );

        // User::create([
        //     'name' => 'Steven Marulitua',
        //     'username' => 'steven_marulitua',
        //     'level' => 2,
        //     'password' => bcrypt('12345'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
