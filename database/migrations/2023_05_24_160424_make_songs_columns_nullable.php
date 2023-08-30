<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->string('file_path')
                ->nullable()
                ->change();
            $table->string('genre')
                ->nullable()
                ->change();
            $table->string('author')
                ->nullable()
                ->change();
            $table->string('arranger')
                ->nullable()
                ->change();
            $table->double('size')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->string('file_path')
                ->change();
            $table->string('genre')
                ->change();
            $table->string('author')
                ->change();
            $table->string('arranger')
                ->change();
            $table->double('size')
                ->change();
        });
    }
};
