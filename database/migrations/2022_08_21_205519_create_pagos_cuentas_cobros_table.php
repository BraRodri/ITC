<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosCuentasCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_cuentas_cobros', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('usuario_id');
            $table->string('numero_cuenta_cobro');
            $table->date('fecha_inicio');
            $table->date('fecha_terminacion');
            $table->string('nombre_usuario');
            $table->string('tipo_documento_usuario');
            $table->string('numero_documento_usuario');
            $table->float('valor', 15, 2)->default(0);
            $table->text('valor_texto')->nullable();
            $table->text('conceptos')->nullable();

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
        Schema::dropIfExists('pagos_cuentas_cobros');
    }
}
