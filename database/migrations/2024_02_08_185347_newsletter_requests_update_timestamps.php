<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('newsletter_requests', function (Blueprint $table) {
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('newsletter_requests', function (Blueprint $table) {
            $table->dropColumn('confirmed_at');
            $table->dropColumn('completed_at');
        });
    }
};
