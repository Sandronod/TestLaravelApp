<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();

            // Which post and which user wrote it
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Self-referencing parent for sub-comments (replies)
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('post_comments')
                ->cascadeOnDelete();

            // Comment content
            $table->text('body');

            // Threading helpers (optional but useful):
            // - level: 0 = top-level, 1+ = depth of reply
            $table->unsignedTinyInteger('level')->default(0);
            // - path: materialized path to speed up "load a whole thread" queries
            //   Example: "000001/000123/000456" (zero-padded ids)
            $table->string('path', 191)->nullable();

            // Moderation / state
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Helpful indexes
            $table->index(['post_id', 'parent_id']);
            $table->index(['post_id', 'path']);              // fast subtree grabs
            $table->index(['post_id', 'created_at']);        // list latest comments
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
