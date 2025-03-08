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
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('creditos');
            $table->unsignedBigInteger('programaformacion_id');
            $table->integer( 'estado');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('programaformacion_id')
            ->references('id')
            ->on('programaformaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturas');
    }
};
