<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->unsignedBigInteger('plz')->unique();
            $table->string('name');
            $table->timestamps();
        });
        if (config('database.default') == 'mysql') {
            DB::statement('alter table venues add constraint plz_check check (plz>=10000 and plz<=99999)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
