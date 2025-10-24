<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name' => 'Ali Reza',
                'email' => 'ali@example.com',
                'phone' => '+989123456789',
                'meta' => json_encode(['source' => 'import']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sara Ahmadi',
                'email' => 'sara@example.com',
                'phone' => '+989198765432',
                'meta' => json_encode(['source' => 'web']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
