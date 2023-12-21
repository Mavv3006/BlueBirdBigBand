<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setlist_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('concert_id');

            //            $table->foreignId('concert_id')->constrained('concerts');
            //            $table->foreign('concert_id')->references('id')->on('concerts');
        });
    }

    public function down(): void
    {
        Schema::table('setlist_entries', function (Blueprint $table) {
            $table->dropColumn('concert_id');
        });
    }
};
