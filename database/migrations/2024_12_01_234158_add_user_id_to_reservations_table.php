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
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id'); // Agrega la columna user_id
            $table->foreign('user_id') // Define la clave foránea
                ->references('id')->on('users') // Apunta a la columna id de la tabla users
                ->onDelete('cascade'); // Elimina las reservaciones si el usuario se elimina
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Elimina la clave foránea
            $table->dropColumn('user_id');   // Elimina la columna
        });
    }
};
