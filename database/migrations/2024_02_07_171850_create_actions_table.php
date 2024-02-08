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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('observation')->nullable();
            $table->boolean('status');
            // Agregar clave foránea
            $table->unsignedBigInteger('movement_type_id');
            $table->timestamps();

            // Definir restricciones de clave foránea
            $table->foreign('movement_type_id')->references('id')->on('movement_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
};
