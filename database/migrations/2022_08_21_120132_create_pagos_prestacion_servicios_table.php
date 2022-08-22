<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosPrestacionServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_prestacion_servicios', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('usuario_id');
            $table->date('fecha_emision');
            $table->string('nombre_usuario');
            $table->string('numero_documento_usuario');
            $table->string('domicilio_usuario')->nullable();
            $table->float('valor', 15, 2)->default(0);
            $table->text('valor_texto')->nullable();
            $table->text('conceptos')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('firma')->nullable();

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
        Schema::dropIfExists('pagos_prestacion_servicios');
    }
}
