<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_bahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_orderan_id');
            $table->string('nama_bahan');
            $table->integer('harga_satuan')->default(0);
            $table->integer('harga_size_besar')->default(0);
            $table->timestamps();

            $table->foreign('jenis_orderan_id')->references('id')->on('tbl_jenis_orderan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_bahan');
    }
}
