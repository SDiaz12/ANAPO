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
            $table->foreignId('asignatura_estudiante_id')->constrained('asignatura_estudiantes')->onDelete('cascade'); 
            $table->float('primerparcial');
            $table->float('segundoparcial')->nullable();
            $table->float('tercerparcial')->nullable();
            $table->string('asistencia');
            $table->float('recuperacion')->nullable();
            $table->string('observacion');
            $table->integer('estado');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            
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
