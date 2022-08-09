<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_servicios', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('estudiante_id');
            $table->date('fecha');
            $table->bigInteger('servicio_id');
            $table->string('tipo_servicio');
            $table->string('servicio');
            $table->float('valor', 15, 2)->default(0);
            $table->integer('estado')->default(1);

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
        Schema::dropIfExists('registro_servicios');
    }
}
