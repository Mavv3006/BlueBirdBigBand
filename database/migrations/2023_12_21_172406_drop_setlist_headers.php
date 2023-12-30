<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('setlist_entries', function (Blueprint $table) {
            $table->dropForeign('setlist_entries_setlist_id_foreign');
            $table->dropColumn('setlist_id');
        });

        Schema::table('setlist_headers', function (Blueprint $table) {
            $table->drop();
        });
    }
};
