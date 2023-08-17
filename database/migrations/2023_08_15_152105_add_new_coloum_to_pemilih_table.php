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
        Schema::table('pemilih', function (Blueprint $table) {
            $table->foreignId('leader_id')->constrained('leaders');
            $table->foreignId('mayor_id')->constrained('users');
            $table->foreignId('kapten_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemilih', function (Blueprint $table) {
            //
        });
    }
};
