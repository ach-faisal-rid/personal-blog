<?php

namespace Modules\Jurnal\Database\Migrations;

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
        Schema::create('posts', function (Blueprint $table) {
            
            // old column
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('social_url');
            $table->timestamps();
            
            // new column
            // $table->string('featured_image')->nullable();
            
            $table->string('slug')->unique();
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('thumbnail_id')->nullable()->constrained('thumbnails');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
