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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained();
            $table->foreignId('schedule_id')->constrained(); // Cambiar a "schedule_id"
            $table->string('status')->default('pending'); // Estatus de la reserva
            $table->unique(['court_id', 'schedule_id']); // Evitar reservas duplicadas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
