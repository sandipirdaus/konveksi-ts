<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrateExistingOrderanData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get all existing orderan
        $orderans = DB::table('tbl_orderan')->get();

        foreach ($orderans as $orderan) {
            // Decode JSON arrays
            $jenis_orderan = json_decode($orderan->jenis_orderan, true) ?? [];
            $bahan = json_decode($orderan->bahan, true) ?? [];
            $warna = json_decode($orderan->warna, true) ?? [];
            $harga_satuan = json_decode($orderan->harga_satuan, true) ?? [];
            $qty = json_decode($orderan->qty, true) ?? [];
            $catatan = json_decode($orderan->catatan, true) ?? [];

            // Get the maximum count to handle all items
            $maxCount = max(
                count($jenis_orderan),
                count($bahan),
                count($warna),
                count($harga_satuan),
                count($qty),
                count($catatan)
            );

            // Insert detail orderan for each item
            for ($i = 0; $i < $maxCount; $i++) {
                // Skip if all values are null
                if (empty($jenis_orderan[$i]) && empty($bahan[$i]) && empty($warna[$i])) {
                    continue;
                }

                DB::table('tbl_detail_orderan')->insert([
                    'orderan_id' => $orderan->id,
                    'jenis_orderan' => $jenis_orderan[$i] ?? null,
                    'bahan' => $bahan[$i] ?? null,
                    'warna' => $warna[$i] ?? null,
                    'harga_satuan' => is_numeric($harga_satuan[$i] ?? 0) ? $harga_satuan[$i] : 0,
                    'qty' => is_numeric($qty[$i] ?? 0) ? $qty[$i] : 0,
                    'detail_size_besar' => null, // Will be handled separately if needed
                    'catatan' => $catatan[$i] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Migrate DP to pembayaran table if exists
            if (!empty($orderan->dp) && $orderan->dp > 0) {
                DB::table('tbl_pembayaran')->insert([
                    'orderan_id' => $orderan->id,
                    'jenis_pembayaran' => 'dp',
                    'jumlah' => $orderan->dp,
                    'tanggal_bayar' => $orderan->tgl_order,
                    'metode_pembayaran' => null,
                    'keterangan' => 'Migrated from existing DP data',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Clear migrated data
        DB::table('tbl_detail_orderan')->truncate();
        DB::table('tbl_pembayaran')->truncate();
    }
}
