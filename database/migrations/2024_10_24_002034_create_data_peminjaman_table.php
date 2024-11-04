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
                $table->unsignedBigInteger('ruangan_id'); 
                $table->string('nama_peminjam');
                $table->date('tgl_peminjaman');
                $table->time('waktu_mulai');
                $table->time('waktu_selesai');
                $table->text('keperluan');
                $table->timestamps();

                // Definisi Foreign Key
                $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade');
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