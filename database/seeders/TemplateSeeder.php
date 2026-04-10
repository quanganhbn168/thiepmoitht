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
        $templates = [
            [
                'name' => 'Modern 01',
                'view_path' => 'templates.modern_01',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Traditional Red (Truyền Thống)',
                'view_path' => 'templates.traditional_red',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Minimal 03 (Tạp Chí)',
                'view_path' => 'templates.minimal_03',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Gold (Vàng Hoàng Gia)',
                'view_path' => 'templates.luxury_gold',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Elegant 02 (Sang Trọng Cổ Điển)',
                'view_path' => 'templates.elegant_02',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Cherry Blossom (Mùa Valentine)',
                'view_path' => 'templates.cherry_blossom',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Galaxy Dreams (Ngân Hà Lung Linh)',
                'view_path' => 'templates.galaxy_dreams',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Simple Card (Danh Thiếp Đơn Giản)',
                'view_path' => 'templates.business.simple_modern',
                'type' => 'business',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            $createdTemplate = \App\Models\Template::updateOrCreate(
                ['view_path' => $template['view_path']],
                $template
            );
            
            // Link existing weddings that match this view_path (Only for weddings)
            if ($createdTemplate->type === 'wedding') {
                 \App\Models\Wedding::where('template_view', $template['view_path'])
                    ->update(['template_id' => $createdTemplate->id, 'type' => 'wedding']);
            }
        }
    }
}
