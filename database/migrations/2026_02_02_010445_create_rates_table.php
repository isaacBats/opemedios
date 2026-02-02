<?php

declare(strict_types=1);

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
        Schema::create('rates', function (Blueprint $table): void {
            $table->id();

            // Foreign keys (all nullable for flexibility)
            $table->foreignId('source_id')
                ->nullable()
                ->constrained('sources')
                ->nullOnDelete();

            $table->foreignId('section_id')
                ->nullable()
                ->constrained('sections')
                ->nullOnDelete();

            $table->foreignId('social_network_id')
                ->nullable()
                ->constrained('social_networks')
                ->nullOnDelete();

            // Content type for social media (post, story, reel, video)
            $table->string('content_type', 50)->nullable();

            // Range values (followers, visits, audience)
            $table->bigInteger('min_value')->default(0);
            $table->bigInteger('max_value')->nullable();

            // Price
            $table->decimal('price', 12, 2);

            // Rate type
            $table->enum('type', ['social', 'internet', 'radio', 'tv', 'print']);

            // Additional metadata (spot duration, URL, etc.)
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Unique composite index to prevent duplicates
            $table->unique([
                'source_id',
                'section_id',
                'social_network_id',
                'content_type',
                'min_value',
                'max_value',
                'type',
            ], 'rates_unique_combination');

            // Indexes for faster lookups
            $table->index(['type', 'source_id']);
            $table->index(['type', 'social_network_id', 'content_type']);
            $table->index(['min_value', 'max_value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
