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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_matricula');
            $table->char('estado', 1);
            $table->string('motivo_estado');
            $table->string('observacion_estado');
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_asignatura');
            $table->unsignedBigInteger('id_seccion');
            $table->string('periodo');
            $table->string('instituto');
            $table->softDeletes();
            $table->unique(['id_estudiante', 'id_asignatura', 'id_seccion']);
            $table->timestamps();

            $table->foreign('id_estudiante')->references('id')->on('estudiantes');
            $table->foreign('id_asignatura')->references('id')->on('asignaturas');
            $table->foreign('id_seccion')->references('id')->on('secciones');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
