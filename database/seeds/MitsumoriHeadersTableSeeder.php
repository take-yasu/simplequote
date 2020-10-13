<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MitsumoriHeadersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mitsumori_headers')->insert([
            'denpyou_number' => 'E0001234',
            'user_code' => '1',
            'user_name' => 'テスト太郎',
            'company_name' => 'テスト株式会社',
            'tel' => '03-1234-1234',
            'fax' => '03-5678-5678',
            'delivery_name' => '納品先次郎',
            'pref_code' => '23',
            'pref_name' => '愛知県',
            'city_name' => '豊橋市',
            'address' => '野寄町1-1',
            'total_sales' => 16500,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'estimated_Date' => Carbon::now(),
        ]);

        DB::table('mitsumori_headers')->insert([
            'denpyou_number' => 'E0054321',
            'user_code' => '2',
            'user_name' => 'テストはな子',
            'company_name' => '静岡不動産',
            'tel' => '054-1234-1234',
            'fax' => '054-5678-5678',
            'delivery_name' => '納品先ジョン',
            'pref_code' => '13',
            'pref_name' => '東京都',
            'city_name' => '港区',
            'address' => '赤坂1-1',
            'total_sales' => 20000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'estimated_Date' => Carbon::now(),
        ]);

        DB::table('mitsumori_headers')->insert([
            'denpyou_number' => 'E0241234',
            'user_code' => '3',
            'user_name' => 'テスト侍',
            'company_name' => 'テスト工務店',
            'tel' => '06-1234-1234',
            'fax' => '06-5678-5678',
            'delivery_name' => 'まるこ',
            'pref_code' => '27',
            'pref_name' => '大阪府',
            'city_name' => '大阪市',
            'address' => '野寄町1-1',
            'total_sales' => 3000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'estimated_Date' => Carbon::now(),
        ]);

        DB::table('mitsumori_headers')->insert([
            'denpyou_number' => 'E0029334',
            'user_code' => '1',
            'user_name' => 'テスト太郎',
            'company_name' => 'テスト株式会社',
            'tel' => '03-1234-1234',
            'fax' => '03-5678-5678',
            'delivery_name' => '納品先三郎',
            'pref_code' => '23',
            'pref_name' => '愛知県',
            'city_name' => '田原市',
            'address' => '新町1-1',
            'total_sales' => 55000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'estimated_Date' => Carbon::now(),
        ]);

    }
}
