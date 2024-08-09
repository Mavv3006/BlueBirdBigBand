<?php

use App\Models\KonzertmeisterEvent;
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
        Schema::table('concerts', function (Blueprint $table) {
            $table->foreignIdFor(KonzertmeisterEvent::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(KonzertmeisterEvent::class);
        });
    }
};
