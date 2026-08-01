<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ijins', function (Blueprint $table) {
           
            $table->date('tanggal_ijin')->after('user_id')->nullable();
             $table->string('total_ijin')->after('tanggal_ijin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ijins', function (Blueprint $table) {
            $table->dropColumn('tanggal_ijin');
        });
    }
};
