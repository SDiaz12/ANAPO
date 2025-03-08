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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignatura_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('periodo_id');
            $table->float('nota');
            $table->string('observacion');
            $table->integer('estado');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('docente_id')->references('id')->on('docentes');
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('restrict');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
