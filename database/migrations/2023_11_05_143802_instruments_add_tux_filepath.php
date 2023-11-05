<?php

use App\Models\Instrument;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('instruments', function (Blueprint $table) {
            $table->string('tux_filepath')->default('');
        });

        $instruments = Instrument::all();
        foreach ($instruments as $instrument) {
            $instrument->tux_filepath = $instrument->default_picture_filepath;
            $instrument->save();
        }
    }

    public function down(): void
    {
        Schema::table('instruments', function (Blueprint $table) {
            $table->dropColumn('tux_filepath');
        });
    }
};
