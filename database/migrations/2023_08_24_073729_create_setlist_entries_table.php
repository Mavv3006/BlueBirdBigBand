<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setlist_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setlist_id')->constrained('setlist_headers');
            $table->foreignId('song_id')->constrained('songs');
            $table->unsignedInteger('sequence_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setlist_entries');
    }
};
