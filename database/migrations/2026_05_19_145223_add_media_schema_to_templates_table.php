<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            if (! Schema::hasColumn('templates', 'media_schema')) {
                $table->json('media_schema')->nullable()->after('view_path');
            }

            if (! Schema::hasColumn('templates', 'metadata')) {
                $table->json('metadata')->nullable()->after('media_schema');
            }
        });
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            if (Schema::hasColumn('templates', 'metadata')) {
                $table->dropColumn('metadata');
            }

            if (Schema::hasColumn('templates', 'media_schema')) {
                $table->dropColumn('media_schema');
            }
        });
    }
};