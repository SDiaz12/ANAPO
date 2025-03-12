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
        Schema::create('asignatura_requisitos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignatura_id'); 
            $table->unsignedBigInteger('requisito_id'); 
            $table->timestamps();

            // Claves foráneas
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('cascade');
            $table->foreign('requisito_id')->references('id')->on('asignaturas')->onDelete('cascade');

            // Evitar duplicados
            $table->unique(['asignatura_id', 'requisito_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignatura_requisito');
    }
};
