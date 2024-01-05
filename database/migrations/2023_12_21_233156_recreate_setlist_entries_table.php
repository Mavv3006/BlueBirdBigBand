<?php

use App\Models\Concert;
use App\Models\Song;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            if (\Illuminate\Support\Facades\DB::table('setlist_entries')->count() == 0) {
                $this->dropSetlistEntryTable();
                $this->createSetlistEntryTable();

                return;
            }
        } catch (QueryException $queryException) {
            print_r($queryException->getMessage());
            $this->createSetlistEntryTable();

            return;
        }

        $this->createSetlistEntryTempTable();
        $this->fillSetlistEntryTempTable();
        $this->dropSetlistEntryTable();
        $this->createSetlistEntryTable();
        $this->fillSetlistEntryTable();
        $this->dropSetlistEntryTempTable();
    }

    private function createSetlistEntryTable(): void
    {
        Schema::create('setlist_entries', function (Blueprint $table) {
            $table->id();
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

            $table->unique(['song_id', 'concert_id']);
        });
    }

    private function fillSetlistEntryTable(): void
    {
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
    }

    private function dropSetlistEntryTempTable(): void
    {
        Schema::table('setlist_entries_temp', function (Blueprint $table) {
            $table->drop();
        });
    }

    private function dropSetlistEntryTable(): void
    {
        Schema::table('setlist_entries', function (Blueprint $table) {
            $table->drop();
        });
    }

    private function fillSetlistEntryTempTable(): void
    {
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
    }

    private function createSetlistEntryTempTable(): void
    {
        Schema::create('setlist_entries_temp', function (Blueprint $table) {
            $table->unsignedBigInteger('song_id');
            $table->unsignedBigInteger('concert_id');
            $table->integer('sequence_number');
            $table->timestamps();
        });
    }
};
