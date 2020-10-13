<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MitsumoriDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mitsumori_details')->insert([
            'denpyou_number' => 'E0001234',
            'row_number' => '01',
            'product_number' => 'MR1001',
            'product_name' => 'マウスピース',
            'quantity' => 5,
            'unit' => '個',
            'unit_price' => 1650,
            'subtotal' => 8250,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('mitsumori_details')->insert([
            'denpyou_number' => 'E0001234',
            'row_number' => '02',
            'product_number' => 'MR1011',
            'product_name' => 'ストラップ',
            'quantity' => 5,
            'unit' => '個',
            'unit_price' => 1650,
            'subtotal' => 8250,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('mitsumori_details')->insert([
            'denpyou_number' => 'E0054321',
            'row_number' => '01',
            'product_number' => 'TT4908',
            'product_name' => 'アルトサックス用リード',
            'quantity' => 10,
            'unit' => '個',
            'unit_price' => 2000,
            'subtotal' => 20000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('mitsumori_details')->insert([
            'denpyou_number' => 'E0241234',
            'row_number' => '01',
            'product_number' => 'TT2000',
            'product_name' => 'リードケース',
            'quantity' => 1,
            'unit' => '個',
            'unit_price' => 3000,
            'subtotal' => 3000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('mitsumori_details')->insert([
            'denpyou_number' => 'E0029334',
            'row_number' => '01',
            'product_number' => 'MR8000',
            'product_name' => '楽譜',
            'quantity' => 11,
            'unit' => '個',
            'unit_price' => 5000,
            'subtotal' => 55000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
