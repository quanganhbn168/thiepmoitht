<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('templates')
            ->where('view_path', 'templates.que-vo-1-teacher')
            ->update(['type' => 'reunion_teacher']);
    }

    public function down(): void
    {
        DB::table('templates')
            ->where('view_path', 'templates.que-vo-1-teacher')
            ->update(['type' => 'reunion']);
    }
};
