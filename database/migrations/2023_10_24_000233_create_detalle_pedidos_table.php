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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente'); // BIGINT(20) */
            $table->unsignedBigInteger('id_pedido')->nullable(); // BIGINT(20)
            $table->unsignedBigInteger('id_producto'); // BIGINT(20)
            $table->integer('cant_producto');
            $table->float('subtotal');

            $table->foreign('id_cliente')->references('id')->on('users');
            $table->foreign('id_pedido')->references('id')->on('pedidos'); 
            $table->foreign('id_producto')->references('id')->on('productos');

            $table->timestamps(); // Agrega automáticamente las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
