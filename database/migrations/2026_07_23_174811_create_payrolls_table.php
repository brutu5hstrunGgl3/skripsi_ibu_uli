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
         Schema::create('payrolls', function (Blueprint $table) {

            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Data payroll
            $table->decimal('gaji_pokok', 15, 2);

            $table->decimal('lembur', 15, 2)->default(0);

            $table->string('no_rek', 30)->nullable();

            $table->string('nama_bank', 50)->nullable();

            $table->enum('jenis_gaji', [
                'Transfer Bank',
                'Payroll Bank',
                'Tunai',
                
            ]);

            // Data absensi
            $table->integer('hadir')->default(0);

            $table->integer('izin')->default(0);

            $table->integer('sakit')->default(0);

            $table->integer('alpha')->default(0);

            // Potongan
            $table->decimal('potongan', 15, 2)->default(0);

            // Bonus
            $table->decimal('bonus', 15, 2)->default(0);

            // Total gaji akhir
            $table->decimal('jumlah_gaji', 15, 2);

            // Periode gaji
            $table->date('periode_awal');

            $table->date('periode_akhir');

            $table->enum('status', [
                'Draft',
                'Diproses',
                'Dibayar'
            ])->default('Draft');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
