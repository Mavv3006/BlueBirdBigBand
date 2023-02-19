<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('concerts', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue_street');
            $table->string('venue_street_number', 5);
            $table->string('venue_description');
            $table->string('event_description');
            $table->timestamps();
            $table->foreignId('band_id')
                ->constrained('bands');
            $table->foreignId('venue_plz')
                ->constrained('venues', 'plz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('concerts');
    }
};
