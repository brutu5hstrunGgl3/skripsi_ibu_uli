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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->date('tgl_masuk');

            $table->date('tgl_pulang')->nullable();

            $table->time('jam_masuk');

            $table->time('jam_pulang')->nullable();

            $table->enum('shift', [
                'Pagi',
                'Siang'
            ]);


            $table->integer('keterlambatan')->default(0)
                ->comment('menit');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
