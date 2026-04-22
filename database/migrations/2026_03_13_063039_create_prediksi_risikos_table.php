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
        Schema::create('prediksi_risiko', function (Blueprint $table) {
    $table->id();
    $table->foreignId('siswa_id')->constrained('siswa');
    $table->decimal('nilai_rata',5,2);
    $table->decimal('kehadiran',5,2);
    $table->integer('poin_pelanggaran');
    $table->enum('hasil_prediksi',['rendah','sedang','tinggi']);
    $table->decimal('confidence',5,2)->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi_risikos');
    }
};
