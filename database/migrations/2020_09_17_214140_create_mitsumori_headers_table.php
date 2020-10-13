<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitsumoriHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitsumori_headers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('denpyou_number', '13');
            $table->string('user_code', '12');
            $table->string('user_name', '60');
            $table->string('company_name', '60');
            $table->string('tel', '20');
            $table->string('fax', '20');
            $table->string('delivery_name', '60');
            $table->string('pref_code', '2');
            $table->string('pref_name', '20');
            $table->string('city_name', '60');
            $table->string('address', '60');
            $table->integer('total_sales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitsumori_headers');
    }
}
