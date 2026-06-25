<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_gallery_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_gallery_post_id')->constrained()->cascadeOnDelete();
            $table->string('session_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('downloaded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_gallery_downloads');
    }
};
