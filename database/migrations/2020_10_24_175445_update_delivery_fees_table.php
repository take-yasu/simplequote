<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeliveryFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_fees', function (Blueprint $table) {
            $table->decimal('fromkm', 10, 2)->change();
            $table->decimal('tokm', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_fees', function (Blueprint $table) {
            $table->integer('fromkm')->change();
            $table->integer('tokm')->change();
        });
    }
}
