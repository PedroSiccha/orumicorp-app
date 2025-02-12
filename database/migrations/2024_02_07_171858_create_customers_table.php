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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('lastname');
            $table->string('dni');
            $table->date('date_admission');
            $table->boolean('status');
            $table->string('img');
            $table->unsignedBigInteger('user_id')->nullable(); // Agregar la columna para la clave foránea
            $table->unsignedBigInteger('agent_id')->nullable(); // Agregar la columna para la clave foránea
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Definir la clave foránea
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade'); // Definir la clave foránea
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
