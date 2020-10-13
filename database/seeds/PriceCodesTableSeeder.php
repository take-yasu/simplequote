<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PriceCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('price_codes')->insert([
            'price_code' => '1',
            'product_number' => 'MR1001',
            'unit_price' => 1650,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_codes')->insert([
            'price_code' => '1',
            'product_number' => 'MR1011',
            'unit_price' => 1650,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_codes')->insert([
            'price_code' => '1',
            'product_number' => 'TT4908',
            'unit_price' => 2000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_codes')->insert([
            'price_code' => '1',
            'product_number' => 'TT2000',
            'unit_price' => 3000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_codes')->insert([
            'price_code' => '1',
            'product_number' => 'MR8000',
            'unit_price' => 5000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
