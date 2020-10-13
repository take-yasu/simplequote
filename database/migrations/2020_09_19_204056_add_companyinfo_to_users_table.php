<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyinfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name', '60');
            $table->string('pref_code', '2');
            $table->string('pref_name', '20');
            $table->string('city_name', '60');
            $table->string('address', '60');
            $table->string('tel', '20');
            $table->string('fax', '20');
            $table->string('price_code', '4');
            $table->string('user_code', '12');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('pref_code');
            $table->dropColumn('pref_name');
            $table->dropColumn('city_name');
            $table->dropColumn('address');
            $table->dropColumn('tel');
            $table->dropColumn('fax');
            $table->dropColumn('price_code');
            $table->dropColumn('user_code');
        });
    }
}
