<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ($this->paths() as $oldPath => $newPath) {
            $oldTemplate = DB::table('templates')->where('view_path', $oldPath)->first();
            $newTemplate = DB::table('templates')->where('view_path', $newPath)->first();

            if ($oldTemplate && $newTemplate) {
                DB::table('reunions')
                    ->where('template_id', $oldTemplate->id)
                    ->update(['template_id' => $newTemplate->id]);

                DB::table('templates')->where('id', $oldTemplate->id)->delete();
                continue;
            }

            if ($oldTemplate) {
                DB::table('templates')
                    ->where('id', $oldTemplate->id)
                    ->update(['view_path' => $newPath]);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->paths() as $oldPath => $newPath) {
            DB::table('templates')
                ->where('view_path', $newPath)
                ->update(['view_path' => $oldPath]);
        }
    }

    private function paths(): array
    {
        return [
            'reunions.standard' => 'templates.standard',
            'reunions.que-vo-1' => 'templates.que-vo-1',
            'reunions.que-vo-1-teacher' => 'templates.que-vo-1-teacher',
            'reunions.que-vo-2' => 'templates.que-vo-2',
        ];
    }
};
