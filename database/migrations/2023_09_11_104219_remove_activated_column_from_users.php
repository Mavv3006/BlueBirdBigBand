<?php

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        User::all()->map(function (User $user) {
            $user->activated ? $user->status = UserStates::Activated : $user->status = UserStates::Registered;
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('activated');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('activated')
                ->default(false);
        });
    }
};
