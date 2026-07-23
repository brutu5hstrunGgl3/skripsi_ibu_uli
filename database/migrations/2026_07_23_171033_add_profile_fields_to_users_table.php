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
        Schema::table('users', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('email');

            $table->string('no_telp', 20)->nullable()->after('alamat');
            $table->string('jabatan')->nullable()->after('no_telp');
              $table->string('jkelamin', 10)->nullable()->after('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'no_telp', 'jabatan', 'jkelamin']);
        });
    }
};
