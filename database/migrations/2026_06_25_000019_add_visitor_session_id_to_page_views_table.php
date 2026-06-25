<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->foreignId('visitor_session_id')->nullable()->constrained()->nullOnDelete();
            $table->index('visitor_session_id');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropForeign(['visitor_session_id']);
            $table->dropIndex(['visitor_session_id']);
            $table->dropColumn('visitor_session_id');
        });
    }
};
