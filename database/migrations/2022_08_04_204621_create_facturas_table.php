<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('registro_servicio_id');
            $table->string('tipo');
            $table->date('fecha');
            $table->float('valor', 15, 2)->default(0);
            $table->float('saldo', 15, 2)->default(0);
            $table->integer('con_firma')->default(0);
            $table->integer('estado')->default(1);
            $table->bigInteger('user_created')->nullable();

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
        Schema::dropIfExists('facturas');
    }
}
