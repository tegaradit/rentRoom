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
        Schema::create('data_peminjaman', function (Blueprint $table) {
                $table->bigIncrements('id'); // Primary key
                $table->unsignedBigInteger('ruangan_id'); // Foreign key ke tabel ruangan
                $table->date('tgl_peminjaman');
                $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
                $table->time('waktu_mulai');
                $table->time('waktu_selesai');
                $table->text('keperluan');
                $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
                $table->timestamps();

                // Definisi Foreign Key
                $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_peminjaman');
    }
};