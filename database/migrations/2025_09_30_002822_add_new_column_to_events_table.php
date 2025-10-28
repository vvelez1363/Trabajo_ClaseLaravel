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
        Schema::table('events', function (Blueprint $table) {
            //CREACION DE LA LLAVE FORANEA
            //NOMBRE DE LA TABLA Y NOMBRE DE LA COLUMNA A LLAMAR
            $table->foreignId('fk_venue_event')->nullable()->constrained('venues', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //ELIMINAR EL CONSTRAINT DE LLAVE FORANEA Y LUEGO LA COLUMNA
            $table->dropForeign(['fk_venue_event']);
            $table->dropColumn('fk_venue_event');
        });
    }
};
