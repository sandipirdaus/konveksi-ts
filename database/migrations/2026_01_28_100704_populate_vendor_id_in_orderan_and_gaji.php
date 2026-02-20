<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PopulateVendorIdInOrderanAndGaji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Populate vendor_id in tbl_orderan based on nama_vendor
        $orderans = DB::table('tbl_orderan')->whereNull('vendor_id')->get();
        
        foreach ($orderans as $orderan) {
            $vendor = DB::table('tbl_vendor')
                ->where('nama_vendor', $orderan->nama_vendor)
                ->first();
            
            if ($vendor) {
                DB::table('tbl_orderan')
                    ->where('id', $orderan->id)
                    ->update(['vendor_id' => $vendor->id]);
            }
        }

        // Populate vendor_id in tbl_gaji_karyawan based on vendor name
        $gajis = DB::table('tbl_gaji_karyawan')->whereNull('vendor_id')->get();
        
        foreach ($gajis as $gaji) {
            $vendor = DB::table('tbl_vendor')
                ->where('nama_vendor', $gaji->vendor)
                ->first();
            
            if ($vendor) {
                DB::table('tbl_gaji_karyawan')
                    ->where('id', $gaji->id)
                    ->update(['vendor_id' => $vendor->id]);
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
        // Set vendor_id to null
        DB::table('tbl_orderan')->update(['vendor_id' => null]);
        DB::table('tbl_gaji_karyawan')->update(['vendor_id' => null]);
    }
}
