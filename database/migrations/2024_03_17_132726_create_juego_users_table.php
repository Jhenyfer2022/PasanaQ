<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juego_users', function (Blueprint $table) {
            $table->id();
            $table->string('rol_juego')->nullable(false);
            $table->unsignedBigInteger('juego_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('juego_id')->references('id')->on('juegos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('juego_users');
    }
};
