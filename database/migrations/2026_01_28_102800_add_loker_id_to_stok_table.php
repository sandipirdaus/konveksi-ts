<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddLokerIdToStokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tambah kolom loker_id (nullable dulu untuk migrasi)
        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->integer('loker_id')->nullable()->after('id')->index();
        });

        // 2. Populate data: Isi loker_id berdasarkan kecocokan nama_loker
        $stoks = DB::table('tbl_stok')->whereNotNull('nama_loker')->get();
        foreach ($stoks as $stok) {
            $loker = DB::table('tbl_loker')
                ->where('nama_loker', $stok->nama_loker)
                ->first();
            
            if ($loker) {
                DB::table('tbl_stok')
                    ->where('id', $stok->id)
                    ->update(['loker_id' => $loker->id]);
            }
        }

        // 3. Tambahkan Foreign Key
        Schema::table('tbl_stok', function (Blueprint $table) {
             $table->foreign('loker_id')
                  ->references('id')
                  ->on('tbl_loker')
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
        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->dropForeign(['loker_id']);
            $table->dropColumn('loker_id');
        });
    }
}
