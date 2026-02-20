<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorIdToOrderanAndGajiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('id')->index();
        });

        Schema::table('tbl_gaji_karyawan', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('id')->index();
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
            $table->dropColumn('vendor_id');
        });

        Schema::table('tbl_gaji_karyawan', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });
    }
}
