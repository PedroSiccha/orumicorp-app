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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('lastname');
            $table->string('dni');
            $table->integer('number_turns')->nullable();
            $table->boolean('status');
            $table->string('img')->nullable();
            // Agregar clave foránea
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Agregar la columna para la clave foránea
            $table->timestamps();

            // Definir restricciones de clave foránea
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Definir la clave foránea
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
};
