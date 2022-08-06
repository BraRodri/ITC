<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_facturas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('factura_id');
            $table->string('tipo');
            $table->string('fecha');
            $table->text('descripcion');
            $table->float('valor')->default(0);
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
        Schema::dropIfExists('pagos_facturas');
    }
}
