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
        Schema::create('pemilih', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tps_id')->nullable()->constrained('tps');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('leader_id')->nullable()->constrained('users');
            $table->foreignId('mayor_id')->nullable()->constrained('users');
            $table->foreignId('kapten_id')->nullable()->constrained('users');
            $table->foreignId('desa_id')->nullable()->constrained('desa');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan');
            $table->string('nama');
            $table->string('namaKecamatan');
            $table->string('namaDesa');
            $table->string('namaTps');
            $table->string('status_memilih')->nullable();
            $table->boolean('is_dpt')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilih');
    }
};
