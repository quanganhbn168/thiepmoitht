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
        Schema::table('reunions', function (Blueprint $table) {
            $table->string('teacher_name')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->text('map_iframe')->nullable();
            $table->string('map_url')->nullable();
            $table->boolean('show_invitation_wrapper')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reunions', function (Blueprint $table) {
            $table->dropColumn([
                'teacher_name',
                'venue_name',
                'venue_address',
                'map_iframe',
                'map_url',
                'show_invitation_wrapper'
            ]);
        });
    }
};
