<?php

use App\Models\Concert;
use App\Models\Song;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setlist_entries_temp', function (Blueprint $table) {
            $table->unsignedBigInteger('song_id');
            $table->unsignedBigInteger('concert_id');
            $table->integer('sequence_number');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::transaction(function () {
            $setlistEntries = \Illuminate\Support\Facades\DB::table('setlist_entries')->get();
            foreach ($setlistEntries as $setlistEntry) {
                \Illuminate\Support\Facades\DB::table('setlist_entries_temp')->insert([
                    'song_id' => $setlistEntry['song_id'],
                    'concert_id' => $setlistEntry['concert_id'],
                    'created_at' => $setlistEntry['created_at'],
                    'updated_at' => $setlistEntry['updated_at'],
                    'sequence_number' => $setlistEntry['sequence_number'],
                ]);
            }
        });

        Schema::table('setlist_entries', function (Blueprint $table) {
            $table->drop();
        });

        Schema::create('setlist_entries', function (Blueprint $table) {
            $table->foreignIdFor(Song::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(Concert::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('sequence_number');
            $table->timestamps();
            $table->primary(['song_id', 'concert_id']);
        });

        \Illuminate\Support\Facades\DB::transaction(function () {
            $setlistEntries = \Illuminate\Support\Facades\DB::table('setlist_entries_temp')->get();
            foreach ($setlistEntries as $setlistEntry) {
                \Illuminate\Support\Facades\DB::table('setlist_entries')->insert([
                    'song_id' => $setlistEntry['song_id'],
                    'concert_id' => $setlistEntry['concert_id'],
                    'created_at' => $setlistEntry['created_at'],
                    'updated_at' => $setlistEntry['updated_at'],
                    'sequence_number' => $setlistEntry['sequence_number'],
                ]);
            }
        });

        Schema::table('setlist_entries_temp', function (Blueprint $table) {
            $table->drop();
        });
    }
};
