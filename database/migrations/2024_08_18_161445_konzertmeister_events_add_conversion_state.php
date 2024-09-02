<?php

use App\Enums\StateMachines\KonzertmeisterEventConversionState;
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
        Schema::table('konzertmeister_events', function (Blueprint $table) {
            $table->string('conversion_state')
                ->default(KonzertmeisterEventConversionState::Open->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konzertmeister_events', function (Blueprint $table) {
            $table->dropColumn('conversion_state');
        });
    }
};
