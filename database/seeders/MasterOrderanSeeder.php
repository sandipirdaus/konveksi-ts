<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterOrderanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate existing data to avoid duplicates, but disable FK check because of the relationship
        Schema::disableForeignKeyConstraints();
        DB::table('tbl_bahan')->truncate();
        DB::table('tbl_jenis_orderan')->truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'T-Shirt' => [
                ['nama' => 'Cotton Combed 24s', 'harga' => 65000, 'extra' => 10000],
                ['nama' => 'Cotton Combed 30s', 'harga' => 150000, 'extra' => 5000], // Based on config
                ['nama' => 'CVC', 'harga' => 85000, 'extra' => 15000], // Assumption or take from others
            ],
            'Jersey' => [
                ['nama' => 'Paragon', 'harga' => 50000, 'extra' => 5000],
                ['nama' => 'Dry-Fit', 'harga' => 55000, 'extra' => 5000],
                ['nama' => 'Serena', 'harga' => 45000, 'extra' => 5000],
            ],
            'Hoodie' => [
                ['nama' => 'Fleece', 'harga' => 95000, 'extra' => 10000],
                ['nama' => 'Baby Terry', 'harga' => 90000, 'extra' => 10000],
            ],
            'PDH' => [
                ['nama' => 'Japan Drill', 'harga' => 120000, 'extra' => 20000],
                ['nama' => 'American Drill', 'harga' => 100000, 'extra' => 15000],
            ],
            'Kemeja' => [
                ['nama' => 'Oxford', 'harga' => 85000, 'extra' => 10000],
                ['nama' => 'Poplin', 'harga' => 80000, 'extra' => 10000],
                ['nama' => 'Toyobo', 'harga' => 95000, 'extra' => 10000],
            ],
            'Kaos Polo' => [
                ['nama' => 'Lacoste CVC', 'harga' => 85000, 'extra' => 15000],
                ['nama' => 'Lacoste PE', 'harga' => 55000, 'extra' => 10000],
            ],
            'Jaket' => [
                ['nama' => 'Taslan', 'harga' => 110000, 'extra' => 15000],
                ['nama' => 'Parasut', 'harga' => 75000, 'extra' => 10000],
            ],
            'Vest' => [
                ['nama' => 'Canvas', 'harga' => 85000, 'extra' => 10000],
                ['nama' => 'Drill', 'harga' => 75000, 'extra' => 10000],
            ],
            'Jas' => [
                ['nama' => 'Wool', 'harga' => 350000, 'extra' => 50000],
                ['nama' => 'Semi Wool', 'harga' => 250000, 'extra' => 35000],
            ],
            'BAJU OLAHRAGA' => [
                ['nama' => 'pe_double', 'harga' => 45000, 'extra' => 5000],
                ['nama' => 'Serena', 'harga' => 45000, 'extra' => 5000],
            ],
            'PDH GURU' => [
                ['nama' => 'Japan Drill', 'harga' => 120000, 'extra' => 20000],
                ['nama' => 'American Drill', 'harga' => 100000, 'extra' => 15000],
            ],
        ];

        foreach ($data as $jenis => $bahans) {
            $jenisId = DB::table('tbl_jenis_orderan')->insertGetId([
                'nama_jenis' => $jenis,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($bahans as $bahan) {
                DB::table('tbl_bahan')->insert([
                    'jenis_orderan_id' => $jenisId,
                    'nama_bahan' => $bahan['nama'],
                    'harga_satuan' => $bahan['harga'],
                    'harga_size_besar' => $bahan['extra'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
