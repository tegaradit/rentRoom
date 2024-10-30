<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->integer('nis')->unique()->nullable();
            $table->integer('nip')->unique()->nullable();
            $table->integer('nik')->unique()->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->foreign('jurusan_id')->references('id')->on('data_jurusan')->onDelete('cascade');
            $table->string('email', 255)->unique();
            $table->string('no_hp', 15); 
            $table->unsignedBigInteger('role_id')->default(2);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('password'); 
            $table->string('photo')->nullable(); 
            $table->text('ttd')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
