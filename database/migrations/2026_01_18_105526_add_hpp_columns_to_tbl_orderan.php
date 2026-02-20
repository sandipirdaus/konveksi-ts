<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHppColumnsToTblOrderan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->integer('hpp_sablon')->nullable()->default(0);
            $table->integer('hpp_benang')->nullable()->default(0);
            $table->integer('hpp_packaging')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->dropColumn(['hpp_sablon', 'hpp_benang', 'hpp_packaging']);
        });
    }
}
