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
        if (Schema::hasIndex('newsletter_requests', 'PRIMARY')) {
            Schema::table('newsletter_requests', function (Blueprint $table) {
                $table->dropPrimary();
            });
        }

        if (Schema::hasColumn('newsletter_requests', 'id')) {
            Schema::table('newsletter_requests', function (Blueprint $table) {
                $table->dropColumn('id');
            });
        }

        Schema::table('newsletter_requests', function (Blueprint $table) {
            $table->uuid('id')->nullable();
        });

        DB::statement('UPDATE newsletter_requests SET id = UUID();');

        Schema::table('newsletter_requests', function (Blueprint $table) {
            $table->uuid('id')->primary()->change(); // 3. Not null and primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasIndex('newsletter_requests', 'PRIMARY')) {
            Schema::table('newsletter_requests', function (Blueprint $table) {
                $table->dropPrimary();
            });
        }

        if (Schema::hasColumn('newsletter_requests', 'id')) {
            Schema::table('newsletter_requests', function (Blueprint $table) {
                $table->dropColumn('id'); // UUID-Spalte entfernen
            });
        }

        Schema::table('newsletter_requests', function (Blueprint $table) {
            $table->id();
        });
    }
};
