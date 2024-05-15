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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion')->nullable();
            $table->float('monto_dinero', 10, 2)->nullable(false);
            $table->date('fecha_limite')->nullable(false);
            $table->string('tipo')->nullable(false);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('turno_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pagos');
    }
};
