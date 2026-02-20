<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToTblBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_bahan', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_bahan', 'harga_satuan')) {
                $table->double('harga_satuan')->default(0);
            }
            if (!Schema::hasColumn('tbl_bahan', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
            // Add unique constraint if not exists (handling potential duplicate error if run multiple times)
            // But Schema::hasTable cannot check constraints easily. However, we can try-catch or just add it.
            // A safer way for constraints in existing table is tricky without checking.
            // Let's assume it doesn't exist or use a name to be safe?
            // Actually, for SQLite/MySQL, adding unique index is fine.
            $table->unique(['jenis_orderan_id', 'nama_bahan'], 'unique_bahan_per_jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_bahan', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_bahan', 'harga_satuan')) {
                $table->dropColumn('harga_satuan');
            }
            if (Schema::hasColumn('tbl_bahan', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
            $table->dropUnique('unique_bahan_per_jenis');
        });
    }
}
