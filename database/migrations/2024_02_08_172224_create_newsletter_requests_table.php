<?php

use App\Enums\StateMachines\NewsletterState;
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
        Schema::create('newsletter_requests', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('email');
            $table->string('type');
            $table->string('status')->default(NewsletterState::Requested->value);
            $table->timestamps();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_requests');
    }
};
