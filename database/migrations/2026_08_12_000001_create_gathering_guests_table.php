<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gathering_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gathering_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code');
            $table->string('greeting')->nullable();
            $table->string('phone')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('guest_count')->default(1);
            $table->string('rsvp_status')->default('pending');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->unique(['gathering_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gathering_guests');
    }
};
