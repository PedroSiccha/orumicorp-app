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
        Schema::create('assistance', function (Blueprint $table) {
            $table->id();
            $table->time('hour');
            $table->date('date');
            $table->string('type');
            $table->string('observation')->nullable();
            // Agregar las claves foráneas
            $table->unsignedBigInteger('agent_id');
            $table->timestamps();

            // Definir las restricciones de clave foránea
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assistance');
    }
};
