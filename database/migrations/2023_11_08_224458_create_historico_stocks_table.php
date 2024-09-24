<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // historico_stock almacena el usuario que modificó el stock de un determinado producto con su fecha dia y hora del insert a esta tabla
        Schema::create('historico_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('num_registro');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_user');
            $table->string('tipo_modif')->notnull(); // almacena el tipo de modificación que corresponde
            $table->string('motivo_modif', 250); // motivo de la modificación
            $table->integer('cantidad_modif')->notnull(); // registra cuanto agregó o quitó al stock
            $table->integer('cantidad_anterior')->notnull(); // registra el stock anterior a la modificación
            $table->integer('cantidad_nueva')->notnull(); // registra el stock resultante de esa modificación
            $table->timestamps(); // registra created_at y updated_at para el histórico

            $table->foreign('id_producto')->references('id')->on('productos');
            // FK de la tabla productos, producto modificado de stock
            $table->foreign('id_user')->references('id')->on('users');
            // FK de la tabla de users, usuario que modifica stock
        });

        // Trigger autoincremental para num_registro
        DB::unprepared('
        CREATE TRIGGER before_insert_historico_stock
        BEFORE INSERT ON historico_stock FOR EACH ROW
        SET NEW.num_registro = IFNULL((SELECT MAX(num_registro) + 1 FROM historico_stock), 1);
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_stock');
    }
};
