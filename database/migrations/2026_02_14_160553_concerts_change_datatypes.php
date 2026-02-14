<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Neue Spalten anlegen (noch nullable, damit wir sie befüllen können)
        Schema::table('concerts', function (Blueprint $table) {
            $table->dateTime('start_at')->after('id')->nullable();
            $table->dateTime('end_at')->after('start_at')->nullable();
        });

        // 2. Daten migrieren: Datum und Uhrzeit zusammenführen
        // Wir nutzen DB::raw, um die Performance zu wahren und direkt in SQL zu arbeiten
        DB::table('concerts')->update([
            'start_at' => DB::raw("CONCAT(date, ' ', start_time)"),
            'end_at' => DB::raw("CASE WHEN end_time IS NOT NULL THEN CONCAT(date, ' ', end_time) ELSE NULL END"),
        ]);

        // 3. Alte Spalten löschen und neue Spalten auf 'required' setzen
        Schema::table('concerts', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable(false)->change();
            $table->dateTime('end_at')->nullable(false)->change();
            $table->dropColumn(['date', 'start_time', 'end_time']);
        });
    }

    public function down(): void
    {
        // Falls wir zurückrollen müssen:
        Schema::table('concerts', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
        });

        DB::table('concerts')->update([
            'date' => DB::raw('DATE(start_at)'),
            'start_time' => DB::raw('TIME(start_at)'),
            'end_time' => DB::raw('TIME(end_at)'),
        ]);

        Schema::table('concerts', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'end_at']);
        });
    }
};
