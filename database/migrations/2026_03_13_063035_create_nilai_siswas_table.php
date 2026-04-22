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
       Schema::create('nilai_siswa', function (Blueprint $table) {
    $table->id();
    $table->foreignId('siswa_id')->constrained('siswa');
    $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran');
    $table->integer('semester');
    $table->decimal('nilai',5,2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswas');
    }
};
