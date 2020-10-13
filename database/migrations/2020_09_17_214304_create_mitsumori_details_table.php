<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitsumoriDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitsumori_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('denpyou_number', '13');
            $table->string('row_number', '2');
            $table->string('product_number', '13');
            $table->string('product_name', '120');
            $table->decimal('quantity', '10', '2');
            $table->string('unit', '20');
            $table->integer('unit_price');
            $table->integer('subtotal');
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
        Schema::dropIfExists('mitsumori_details');
    }
}
