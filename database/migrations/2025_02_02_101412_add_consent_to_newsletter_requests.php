<?php

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
        Schema::table('newsletter_requests', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable();
            $table->string('data_privacy_consent_text')->nullable();
            $table->boolean('data_privacy_consent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter_requests', function (Blueprint $table) {
            $table->dropColumn('consent_ip');
            $table->dropColumn('data_privacy_consent_text');
            $table->dropColumn('data_privacy_consent');
        });
    }
};
