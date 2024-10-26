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
        Schema::table('concerts', function (Blueprint $table) {
            $table->text('newsletter_content_markdown')->nullable();
            $table->boolean('newsletter_sent')->default(false);
            $table->dateTime('newsletter_sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            $table->dropColumn('newsletter_content_markdown');
            $table->dropColumn('newsletter_sent');
            $table->dropColumn('newsletter_sent_at');
        });
    }
};
