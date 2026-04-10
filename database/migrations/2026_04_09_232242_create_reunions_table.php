<?php

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
        Schema::create('reunions', function (Blueprint $table) {
                        $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedBigInteger('template_id')->nullable();
            $table->string('slug')->unique();
            $table->string('school_name')->nullable();
            $table->string('class_name')->nullable();
            $table->string('graduation_year')->nullable();
            $table->string('status')->default('draft');
            $table->string('tier')->default('standard');
            $table->string('falling_effect')->default('leaves');
            $table->string('background_music')->nullable();
            $table->date('event_date')->nullable();
            $table->dateTime('event_time')->nullable();
            $table->json('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_auto_approve_messages')->default(true);
            $table->boolean('is_demo')->default(true);
            $table->boolean('show_preload')->default(true);
            $table->boolean('can_share')->default(true);
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};
