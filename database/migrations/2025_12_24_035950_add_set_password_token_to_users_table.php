<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('set_password_token')->nullable()->unique()->after('remember_token');
            $table->timestamp('set_password_token_expired_at')->nullable()->after('set_password_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'set_password_token',
                'set_password_token_expired_at',
            ]);
        });
    }
};
