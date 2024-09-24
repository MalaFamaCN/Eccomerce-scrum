<?php
//Migración creada por AJazure

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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id(); // Autoincremental?
            $table->string('descripcion', 40);
            $table->string('cuit', 18)->nullable();
            $table->string('razon_social', 30)->nullable();
            $table->string('direccion', 40)->nullable();
            $table->bigInteger('telefono')->nullable();
            $table->string('correo', 30)->nullable();
            $table->boolean('activo')->default(1);
            $table->timestamps(); // Agrega automáticamente las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
