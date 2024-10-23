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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan', 50);
            $table->integer('kapasitas');
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->enum('status', ['tersedia', 'terpinjam'])->default('tersedia');  // Menambahkan kolom enum status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
