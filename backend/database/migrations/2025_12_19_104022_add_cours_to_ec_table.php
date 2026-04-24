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
        Schema::table('ecs', function (Blueprint $table) {
            // Ajout de la colonne cours
            $table->string('cours')->nullable()->after('nb_heures_ec');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecs', function (Blueprint $table) {
            // Suppression de la colonne cours si rollback
            $table->dropColumn('cours');
        });
    }
};
