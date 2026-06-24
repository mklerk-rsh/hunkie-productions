<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('ip_address', 45)->nullable()->after('notes');
            $table->decimal('latitude', 10, 7)->nullable()->after('ip_address');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->text('user_agent')->nullable()->after('longitude');
            $table->text('referrer_url')->nullable()->after('user_agent');
            $table->text('landing_page')->nullable()->after('referrer_url');
            $table->integer('time_spent_seconds')->default(0)->after('landing_page');
            $table->integer('page_views_count')->default(1)->after('time_spent_seconds');
            $table->string('device_type', 20)->nullable()->after('page_views_count');
            $table->string('browser', 50)->nullable()->after('device_type');
            $table->string('os', 50)->nullable()->after('browser');
            $table->string('session_id', 255)->nullable()->unique()->after('os');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'ip_address', 'latitude', 'longitude', 'user_agent',
                'referrer_url', 'landing_page', 'time_spent_seconds',
                'page_views_count', 'device_type', 'browser', 'os', 'session_id',
            ]);
            $table->string('name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });
    }
};
