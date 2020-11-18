<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZipToMitsumoriHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mitsumori_headers', function (Blueprint $table) {
            $table->string('zip', '7');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mitsumori_headers', function (Blueprint $table) {
            $table->dropColumn('zip');
        });
    }
}
