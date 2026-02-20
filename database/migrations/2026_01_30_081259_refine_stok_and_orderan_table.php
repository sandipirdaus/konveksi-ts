<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefineStokAndOrderanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->json('size_details')->nullable()->after('qty');
        });

        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->json('size_details')->nullable()->after('qty');
            if (!Schema::hasColumn('tbl_stok', 'created_at')) {
                $table->timestamps();
            }
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
            $table->dropColumn('size_details');
        });

        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->dropColumn('size_details');
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}
