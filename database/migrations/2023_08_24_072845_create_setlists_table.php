<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('setlist_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concert_id')->constrained('concerts');
            $table->timestamps();

            $table->unique(['concert_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setlist_headers');
    }
};
