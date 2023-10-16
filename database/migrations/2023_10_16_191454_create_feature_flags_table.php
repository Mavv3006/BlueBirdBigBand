<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_flags', function (Blueprint $table) {
            $table->string('status');
            $table->string('name');
            $table->timestamps();

            $table->primary('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
