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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            /* $table->unsignedBigInteger('id_metodo_de_pago'); // BIGINT(20) */ 
            $table->unsignedBigInteger('id_cliente'); // BIGINT(20)
            /* $table->dateTime('fecha_hora');  */// BIGINT(20)

            $table->string('nombre', 40);
            $table->string('apellido', 40);
            $table->string('correo', 40);
            $table->unsignedBigInteger('telefono');
            $table->unsignedBigInteger('dni');

            $table->bigInteger('num_pedido')->unique();
            $table->bigInteger('num_seguimiento')->nullable()->unique();

            $table->string('direccion', 80);
            $table->string('codigo_postal', 20);

            $table->boolean('pagado')->default(0);
            $table->boolean('en_preparacion')->default(0);
            $table->boolean('cancelado')->default(0);
            $table->boolean('enviado')->default(0);
            $table->bigInteger('total')->default(0);
            $table->string('linkDePago')->nullable();
            $table->string('urlFactura')->nullable();
            $table->string('factura_enviada')->nullable();
            /* $table->foreign('id_metodo_de_pago')->references('id')->on('metodos_de_pago'); */
            $table->foreign('id_cliente')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
