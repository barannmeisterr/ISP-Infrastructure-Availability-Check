<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AltyapiTurleriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('altyapi_turleri')->insert([
            ['xdsltype' => 1, 'altyapi_adi' => 'ADSL'],
            ['xdsltype' => 6, 'altyapi_adi' => 'VDSL'],
            ['xdsltype' => 7, 'altyapi_adi' => 'FIBER'],
        ]);
    }
}

