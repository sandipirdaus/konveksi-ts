<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUserIdToOrderanAndStok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Add user_id to tbl_orderan
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->index();
        });

        // 2. Add user_id to tbl_stok
        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id')->index();
        });

        // 3. Migrate Data: Populate user_id based on 'pemeriksa' name matches
        $this->populateUserId('tbl_orderan', 'pemeriksa');
        $this->populateUserId('tbl_stok', 'pemeriksa');

        // 4. Add constraints
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    protected function populateUserId($tableName, $columnName)
    {
        $records = DB::table($tableName)->whereNotNull($columnName)->get();
        foreach ($records as $record) {
            // Find user by name (assuming pemeriksa stores the name)
            $user = DB::table('users')->where('name', $record->{$columnName})->first();
            
            if ($user) {
                DB::table($tableName)
                    ->where('id', $record->id)
                    ->update(['user_id' => $user->id]);
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
        Schema::table('tbl_orderan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('tbl_stok', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
