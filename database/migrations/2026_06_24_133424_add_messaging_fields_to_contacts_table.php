<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('subject')->nullable()->after('phone');
            $table->text('message')->nullable()->after('subject');
            $table->boolean('is_read')->default(false)->after('opted_in');
            $table->timestamp('replied_at')->nullable()->after('is_read');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['subject', 'message', 'is_read', 'replied_at']);
        });
    }
};
