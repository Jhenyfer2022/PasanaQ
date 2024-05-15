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
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            
            $table->string('nombre')->nullable(false);
            $table->integer('limite_maximo_de_integrantes')->nullable(false);
            $table->integer('limite_minimo_de_integrantes')->nullable(false);
            $table->string('estado')->default('no iniciado');

            $table->date('fecha_de_inicio')->nullable(false);
            $table->integer('intervalo_tiempo')->nullable(false);
            $table->float('monto_dinero_individual', 10, 2)->nullable(false); // Precisión de 8 dígitos y 2 decimales
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
        Schema::dropIfExists('juegos');
    }
};
