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
         Schema::create('enseigne', function (Blueprint $table) {
            $table->string('code_ec', 20); // cohérent avec ec.code_ec
            $table->foreign('code_ec')->references('code_ec')->on('ecs')->onDelete('cascade');

            $table->string('code_personnel', 20); // <-- modifié en varchar
            $table->foreign('code_personnel')->references('code_personnel')->on('personnel')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseigne');
    }
};
