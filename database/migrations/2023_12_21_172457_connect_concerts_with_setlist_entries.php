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
        });
    }

    public function down(): void
    {
        Schema::table('setlist_entries', function (Blueprint $table) {
            $table->dropColumn('concert_id');
        });
    }
};
