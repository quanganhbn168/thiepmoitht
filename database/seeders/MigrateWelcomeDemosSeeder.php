<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wedding;
use App\Models\BusinessCard;
use App\Models\Template;
use App\Models\User;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Enums\FallingEffect;

class MigrateWelcomeDemosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedWeddings();
        $this->seedBusinessCards();
    }

    private function seedWeddings()
    {
        $demos = [
            [
                'slug' => 'minh-quang-thu-ha-2025',
                'groom_name' => 'Minh Quang',
                'bride_name' => 'Thu Hà',
                'view_path' => 'templates.modern_01',
                'template_name' => 'Modern Style (Hồng Phấn Hiện Đại)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=400',
            ],
            [
                'slug' => 'duc-long-ngoc-anh-2025',
                'groom_name' => 'Đức Long',
                'bride_name' => 'Ngọc Anh',
                'view_path' => 'templates.elegant_02',
                'template_name' => 'Elegant Style (Vàng Gold Sang Trọng)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1550005809-91ad75fb315f?q=80&w=400',
            ],
            [
                'slug' => 'hoang-anh-minh-chau-2025',
                'groom_name' => 'Hoàng Anh',
                'bride_name' => 'Minh Châu',
                'view_path' => 'templates.minimal_03',
                'template_name' => 'Minimal Style (Tối Giản Tinh Tế)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1607190074257-dd4b7af0309f?q=80&w=400',
            ],
            [
                'slug' => 'van-hung-thanh-tam-2025',
                'groom_name' => 'Văn Hùng',
                'bride_name' => 'Thanh Tâm',
                'view_path' => 'templates.traditional_red',
                'template_name' => 'Traditional Red (Đỏ Truyền Thống)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?q=80&w=400',
            ],
            [
                'slug' => 'quoc-bao-kim-ngan-2025',
                'groom_name' => 'Quốc Bảo',
                'bride_name' => 'Kim Ngân',
                'view_path' => 'templates.luxury_gold',
                'template_name' => 'Luxury Gold (Vàng Kim Cổ Điển)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=400',
            ],
        ];

        $admin = User::first() ?? User::factory()->create();

        foreach ($demos as $demo) {
            $template = Template::firstOrCreate(
                ['view_path' => $demo['view_path']],
                [
                    'name' => $demo['template_name'],
                    'type' => 'wedding',
                    'is_active' => true,
                    'tier' => 'standard', 
                ]
            );
            // Ensure thumbnail is set even if template existed
            if (isset($demo['thumbnail_url'])) {
                $template->update(['thumbnail_url' => $demo['thumbnail_url']]);
            }

            Wedding::updateOrCreate(
                ['slug' => $demo['slug']],
                [
                    'user_id' => $admin->id,
                    'template_id' => $template->id,
                    'template_view' => $demo['view_path'], // Legacy support
                    'groom_name' => $demo['groom_name'],
                    'bride_name' => $demo['bride_name'],
                    'event_date' => now()->addDays(rand(30, 90)),
                    'status' => WeddingStatus::PUBLISHED->value,
                    'tier' => WeddingTier::PRO->value,
                    'is_demo' => true,
                    'is_active' => true,
                    'is_auto_approve_wishes' => true,
                    'can_share' => true,
                    'falling_effect' => FallingEffect::HEARTS->value,
                ]
            );
        }
    }

    private function seedBusinessCards()
    {
        $demos = [
            [
                'slug' => 'nguyen-van-an',
                'name' => 'Nguyễn Văn An',
                'position' => 'CEO & Founder',
                'company' => 'THT Media',
                'view_path' => 'templates.business.simple_card', // Placeholder path
                'template_name' => 'CEO Profile (Premium Landing)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400',
            ],
            [
                'slug' => 'tran-quang-anh',
                'name' => 'Trần Quang Anh',
                'position' => 'Creative Director',
                'company' => 'Design Studio',
                'view_path' => 'templates.business.luxury_gold', // Placeholder path
                'template_name' => 'Luxury Gold (Business)', 
                'thumbnail_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=400',
            ],
             [
                'slug' => 'le-minh-tu',
                'name' => 'Lê Minh Tú',
                'position' => 'Marketing Manager',
                'company' => 'Global Corp',
                 'view_path' => 'templates.business.minimal_white', // Placeholder path
                'template_name' => 'Minimal White (Business)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400',
            ],
            [
                'slug' => 'pham-thi-huong',
                'name' => 'Phạm Thị Hương',
                'position' => 'HR Director',
                'company' => 'HR Solutions',
                 'view_path' => 'templates.business.corporate_blue', // Placeholder path
                'template_name' => 'Corporate Blue (Business)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400',
            ],
            [
                'slug' => 'do-hoang-nam',
                'name' => 'Đỗ Hoàng Nam',
                'position' => 'DJ / Artist',
                'company' => 'Nightlife Ent',
                 'view_path' => 'templates.business.creative_dark', // Placeholder path
                'template_name' => 'Creative Dark (Business)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=400',
            ],
            [
                'slug' => 'vu-duc-thanh',
                'name' => 'Vũ Đức Thành',
                'position' => 'Blockchain Dev',
                'company' => 'Tech Lab',
                 'view_path' => 'templates.business.tech_gradient', // Placeholder path
                'template_name' => 'Tech Gradient (Business)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=400',
            ],
             [
                'slug' => 'hoang-thi-mai',
                'name' => 'Hoàng Thị Mai',
                'position' => 'Sales Executive',
                'company' => 'Real Estate',
                 'view_path' => 'templates.business.simple_card', // Duplicate path, same template
                'template_name' => 'Simple Card (Business)',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=400',
            ],
        ];

        $admin = User::first();

        foreach ($demos as $demo) {
            // Find or create template (assuming generic template for now if path not verified)
             $template = Template::firstOrCreate(
                ['view_path' => $demo['view_path']],
                [
                    'name' => $demo['template_name'],
                    'type' => 'business',
                    'is_active' => true,
                    'tier' => 'standard', 
                ]
            );
            // Ensure thumbnail is set even if template existed
            if (isset($demo['thumbnail_url'])) {
                $template->update(['thumbnail_url' => $demo['thumbnail_url']]);
            }

            BusinessCard::updateOrCreate(
                ['slug' => $demo['slug']],
                [
                    'user_id' => $admin->id,
                    'template_id' => $template->id,
                    'name' => $demo['name'], // Ensure 'name' column exists or use content json
                    // Note: BusinessCard usually stores data in 'content' JSON column
                    'content' => [
                        'full_name' => $demo['name'],
                        'position' => $demo['position'],
                        'company' => $demo['company'],
                        'website' => 'https://thtmedia.com.vn',
                        'email' => 'contact@thtmedia.com.vn',
                        'phone' => '0965625210',
                        'address' => 'Hà Nội, Việt Nam',
                        'bio' => 'Chuyên gia với 10 năm kinh nghiệm trong lĩnh vực.',
                    ],
                    'is_active' => true,
                    'is_demo' => true,
                ]
            );
        }
    }
}
