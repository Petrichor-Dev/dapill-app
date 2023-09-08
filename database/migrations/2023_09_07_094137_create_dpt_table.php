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
        Schema::create('dpt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tps_id')->nullable()->constrained('tps');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('desa_id')->nullable()->constrained('desa');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan');
            $table->string('namaKecamatan');
            $table->string('namaDesa');
            $table->string('namaTps');
            $table->string('nama');
            $table->string('nik');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpt');
    }
};
