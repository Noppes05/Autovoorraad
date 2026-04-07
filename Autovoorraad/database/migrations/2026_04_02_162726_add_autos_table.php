<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Uuid as UidUuid;
use Symfony\Polyfill\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('autos', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('merk');
            $table->string('model');
            $table->string('kenteken');
            $table->decimal('prijs', 10, 2);
            $table->integer('km_stand');
            $table->year('bouwjaar');
            $table->text('beschrijving')->nullable();
            $table->string('status')->default('beschikbaar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autos');
    }
};
