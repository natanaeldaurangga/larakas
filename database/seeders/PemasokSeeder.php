<?php

namespace Database\Seeders;

use App\Models\Pemasok;
use Database\Factories\PemasokFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pemasok::factory(20)->create();
    }
}
