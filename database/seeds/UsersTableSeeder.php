<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => '安井 猛',
            'email' => 'yasui@dummy',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'company_name' => '株式会社やすい',
            'pref_code' => '22',
            'pref_name' => '静岡県',
            'city_name' => '静岡市駿河区',
            'address' => '勾金',
            'tel' => '054-111-1111',
            'fax' => '054-222-2222',
            'price_code' => '1',
            'user_code' => '100001',
        ]);


    }
}
