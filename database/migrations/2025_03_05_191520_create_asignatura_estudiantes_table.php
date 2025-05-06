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
        Schema::create('asignatura_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignatura_id')->constrained('asignaturadocentes')->onDelete('cascade');
            $table->foreignId('estudiantes_id')->constrained('matriculas')->onDelete('cascade'); 
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');
            $table->integer( 'estado');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignatura_estudiantes');
    }
};
