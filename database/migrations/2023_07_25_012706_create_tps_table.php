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
        Schema::create('tps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('desa_id')->nullable()->constrained('desa');
            $table->string('namaDesa');
            $table->string('namaKecamatan');
            $table->string('nama');
            $table->string('ketua')->nullable();
            $table->integer('jumlah_pemilih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tps');
    }
};
