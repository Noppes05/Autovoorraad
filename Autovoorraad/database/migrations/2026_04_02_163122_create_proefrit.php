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
        Schema::create('proefrit', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('auto_id')->constrained()->cascadeOnDelete();
            $table->string('naam');
            $table->string('email');
            $table->string('telefoonnummer');
            $table->dateTime('datum_tijd');
            $table->text('bericht')->nullable();
            $table->string('status')->default('gepland');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['auto_id', 'datum_tijd']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proefrit');
    }
};
