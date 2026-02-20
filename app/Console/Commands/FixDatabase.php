<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class FixDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix database schema for tbl_stok';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting database fix...');

        // 1. Check if table exists
        if (!Schema::hasTable('tbl_stok')) {
             $this->error('Table tbl_stok does not exist!');
             return 1;
        }

        // 2. Check/Add 'catatan' column
        if (!Schema::hasColumn('tbl_stok', 'catatan')) {
            $this->info('Adding "catatan" column to tbl_stok...');
            try {
                Schema::table('tbl_stok', function (Blueprint $table) {
                    $table->text('catatan')->nullable()->after('status');
                });
                $this->info('Column "catatan" added successfully.');
            } catch (\Exception $e) {
                $this->error('Failed to add column: ' . $e->getMessage());
                return 1;
            }
        } else {
            $this->info('Column "catatan" already exists.');
        }

        // 3. Clear Cache
        $this->info('Clearing application cache...');
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('view:clear');
        
        $this->info('Database fix completed.');
        return 0;
    }
}
