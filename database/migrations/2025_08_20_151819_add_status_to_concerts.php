<?php

use App\Enums\ConcertStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            $table->enum('status', ConcertStatus::cases())->default(ConcertStatus::Draft);
        });

        DB::table('concerts')
            ->update(['status' => ConcertStatus::Public]);
    }

    public function down(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
