<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblDetailOrderanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_detail_orderan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('orderan_id')->index();
            $table->string('jenis_orderan')->nullable();
            $table->string('bahan')->nullable();
            $table->string('warna')->nullable();
            $table->integer('harga_satuan')->default(0);
            $table->integer('qty')->default(0);
            $table->longText('detail_size_besar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('orderan_id')
                  ->references('id')
                  ->on('tbl_orderan')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_detail_orderan');
    }
}
