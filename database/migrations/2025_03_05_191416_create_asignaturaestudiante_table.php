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
        Schema::create('asignaturaestudiantes', function (Blueprint $table) {
            $table->id();
            $table->integer('nota');
            $table->string('observaciones')->nullable();
            $table->enum('estado', ['A', 'I'])->default('A');
            $table->unsignedBigInteger('id_asignatura');
            $table->unsignedBigInteger('id_estudiante');
            $table->unique(['id_asignatura', 'id_estudiante']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_asignatura')->references('id')->on('asignaturas')->onDelete('restrict');
            $table->foreign('id_estudiante')->references('id')->on('estudiantes')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturaestudiantes');
    }
};
