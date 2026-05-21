<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'reunions.standard' => 'templates.standard',
            'reunions.que-vo-1' => 'templates.que-vo-1',
            'reunions.que-vo-1-teacher' => 'templates.que-vo-1-teacher',
            'reunions.que-vo-2' => 'templates.que-vo-2',
        ] as $oldPath => $newPath) {
            $oldTemplate = \App\Models\Template::where('view_path', $oldPath)->first();
            $newTemplate = \App\Models\Template::where('view_path', $newPath)->first();

            if ($oldTemplate && $newTemplate) {
                \App\Models\Reunion::where('template_id', $oldTemplate->id)
                    ->update(['template_id' => $newTemplate->id]);

                $oldTemplate->delete();
                continue;
            }

            if ($oldTemplate) {
                $oldTemplate->update(['view_path' => $newPath]);
            }
        }

        $templates = [
            [
                'name' => 'Họp lớp chuẩn',
                'view_path' => 'templates.standard',
                'type' => 'reunion',
                'required_tier' => 'standard',
                'is_active' => true,
            ],
            [
                'name' => 'Họp lớp Quế Võ 1',
                'view_path' => 'templates.que-vo-1',
                'type' => 'reunion',
                'required_tier' => 'standard',
                'is_active' => true,
            ],
            [
                'name' => 'Họp lớp Quế Võ 1 - Thầy cô',
                'view_path' => 'templates.que-vo-1-teacher',
                'type' => 'reunion_teacher',
                'required_tier' => 'standard',
                'is_active' => true,
            ],
            [
                'name' => 'Họp lớp Quế Võ 2',
                'view_path' => 'templates.que-vo-2',
                'type' => 'reunion',
                'required_tier' => 'standard',
                'is_active' => true,
            ],
            [
                'name' => 'Họp lớp 001',
                'view_path' => 'templates.templates_001',
                'type' => 'reunion',
                'required_tier' => 'standard',
                'is_active' => true,
            ],
            [
                'name' => 'Thiệp thầy cô 001',
                'view_path' => 'templates.templates_001_teacher',
                'type' => 'reunion_teacher',
                'required_tier' => 'standard',
                'is_active' => true,
            ],
        ];

        \App\Models\Template::whereNotIn('type', ['reunion', 'reunion_teacher'])->delete();

        foreach ($templates as $template) {
            \App\Models\Template::updateOrCreate(
                ['view_path' => $template['view_path']],
                $template
            );
        }
    }
}
