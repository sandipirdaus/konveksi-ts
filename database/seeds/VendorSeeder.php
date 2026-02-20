<?php

use Illuminate\Database\Seeder;
use App\OrderModel;
use App\VendorModel;
use App\GajiKaryawanModel;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Populate Vendors from Orderan
        $orders = OrderModel::all();
        foreach ($orders as $order) {
            if ($order->nama_vendor) {
                $vendor = VendorModel::firstOrCreate(
                    ['nama_vendor' => $order->nama_vendor],
                    // Optional: You could populate known address/phone if you had source, but here we just init
                    []
                );
                
                // Update Order link
                if (is_null($order->vendor_id)) {
                    $order->vendor_id = $vendor->id;
                    $order->save();
                }
            }
        }

        // 2. Populate Vendors from GajiKaryawan (in case there are vendors only in gaji?)
        // Usually valid vendors come from Order, but let's check legacy data in Gaji
        $gajis = GajiKaryawanModel::all();
        foreach ($gajis as $gaji) {
            if ($gaji->vendor) { // legacy column 'vendor' holds name
                 $vendor = VendorModel::firstOrCreate(
                    ['nama_vendor' => $gaji->vendor]
                );

                if (is_null($gaji->vendor_id)) {
                    $gaji->vendor_id = $vendor->id;
                    $gaji->save();
                }
            }
        }
    }
}
