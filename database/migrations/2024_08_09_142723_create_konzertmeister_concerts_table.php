<?php

use App\Models\Band;
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
        Schema::create('konzertmeister_events', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->foreignIdFor(Band::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->datetime('dtstart')->nullable();
            $table->datetime('dtend')->nullable();

            $table->string('summary')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();

            $table->string('location')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konzertmeister_events');
    }
};
