<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'product_number' => 'MR1001',
            'product_name' => 'マウスピース',
            'list_price' => 2200,
            'weight' => 0.2,
            'unit' => '個',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'product_number' => 'MR1011',
            'product_name' => 'ストラップ',
            'list_price' => 2200,
            'weight' => 0.3,
            'unit' => '本',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'product_number' => 'MR8000',
            'product_name' => '楽譜',
            'list_price' => 6250,
            'weight' => 0.5,
            'unit' => '冊',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'product_number' => 'TT4908',
            'product_name' => 'アルトサックス用リード',
            'list_price' => 2500,
            'weight' => 0.3,
            'unit' => '箱',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('products')->insert([
            'product_number' => 'TT2000',
            'product_name' => 'リードケース',
            'list_price' => 3750,
            'weight' => 0.5,
            'unit' => '個',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
