<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add foreign key to tbl_orderan
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('tbl_vendor')
                  ->onDelete('set null');
        });

        // Add foreign key to tbl_gaji_karyawan
        Schema::table('tbl_gaji_karyawan', function (Blueprint $table) {
            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('tbl_vendor')
                  ->onDelete('set null');
        });

        // Add orderan_id column and foreign key to tbl_stok
        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->integer('orderan_id')->nullable()->after('id')->index();
            $table->foreign('orderan_id')
                  ->references('id')
                  ->on('tbl_orderan')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foreign keys
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('tbl_gaji_karyawan', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->dropForeign(['orderan_id']);
            $table->dropColumn('orderan_id');
        });
    }
}
