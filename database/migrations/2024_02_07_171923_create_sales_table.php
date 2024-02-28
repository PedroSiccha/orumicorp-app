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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date_admission');
            $table->decimal('amount');
            $table->decimal('percent')->nullable();
            $table->decimal('exchange_rate')->nullable();
            $table->decimal('commission')->nullable();
            $table->string('observation')->nullable();
            $table->boolean('status');
            // Agregar las claves foráneas
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('action_id');
            $table->timestamps();

            // Definir las restricciones de clave foránea
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
