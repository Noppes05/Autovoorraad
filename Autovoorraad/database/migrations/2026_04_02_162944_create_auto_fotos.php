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
        Schema::create('auto_fotos', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('auto_id')->constrained()->cascadeOnDelete();
            $table->string('foto_path');
            $table->integer('volgorde_nummer');
            $table->timestamps();

            $table->unique(['auto_id', 'volgorde_nummer']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_fotos');
    }
};
