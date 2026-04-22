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
        Schema::create('kehadiran_siswa', function (Blueprint $table) {
    $table->id();
    $table->foreignId('siswa_id')->constrained('siswa');
    $table->integer('semester');
    $table->integer('jumlah_hadir');
    $table->integer('jumlah_izin');
    $table->integer('jumlah_alpha');
    $table->decimal('persentase_kehadiran',5,2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran_siswas');
    }
};
