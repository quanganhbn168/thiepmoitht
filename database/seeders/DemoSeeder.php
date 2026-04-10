<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\BusinessCard;
use App\Models\Wedding;
use App\Models\User;
use Illuminate\Support\Str;
use App\Enums\WeddingTier;
use App\Enums\WeddingStatus;
use App\Enums\FallingEffect;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds to create demo data for all templates.
     */

    public function run(): void
    {
        $this->command->info('� Starting Demo Seeder...');
        
        // AdminUserSeeder, TemplateSeeder handled by DatabaseSeeder
        $this->seedBusinessCards();
        $this->seedWeddings();
        
        $this->command->info('✅ Demo Seeder completed successfully!');
    }

    /**
     * Seed Business Cards with demo data
     */
    private function seedBusinessCards(): void
    {
        $this->command->info('💼 Seeding Business Cards...');

        $demoCards = [
            [
                'name' => 'Nguyễn Văn A',
                'title' => 'CEO & Founder',
                'slug' => 'nguyen-van-a',
                'template_view' => 'templates.business.simple_modern',
                'content' => ['company' => 'THT Media', 'phone' => '0965625210', 'email' => 'contact@thtmedia.com.vn'],
            ],
            [
                'name' => 'Trần Thị B',
                'title' => 'Marketing Manager',
                'slug' => 'tran-thi-b',
                'template_view' => 'templates.business.creative_dark',
                'content' => ['company' => 'Agency XYZ', 'phone' => '0909090909', 'email' => 'marketing@agency.xyz'],
            ],
            [
                'name' => 'Lê Hoàng nam',
                'title' => 'Senior Developer',
                'slug' => 'le-hoang-nam',
                'template_view' => 'templates.business.tech_gradient',
                'content' => ['company' => 'Tech Corp', 'phone' => '0988888888', 'email' => 'dev@tech.corp'],
            ],
        ];

        foreach ($demoCards as $cardData) {
            // Find or create template if missing (simplified logic)
            $template = Template::firstOrCreate(
                ['view_path' => $cardData['template_view']],
                ['name' => $cardData['title'] . ' Template', 'type' => 'business_card']
            );

            BusinessCard::updateOrCreate(
                ['slug' => $cardData['slug']],
                [
                    'user_id' => 1, // Assign to admin
                    'template_id' => $template->id,
                    'name' => $cardData['name'],
                    'title' => $cardData['title'],
                    'content' => $cardData['content'],
                    'is_demo' => true,
                    'is_active' => true,
                ]
            );
             $this->command->info("   ✓ Business Card: {$cardData['name']}");
        }
    }

    /**
     * Seed Weddings with demo data
     */
    private function seedWeddings(): void
    {
        $this->command->info('💒 Seeding Wedding Invitations...');

        $demoWeddings = [
            // Modern 01
            [
                'groom_name' => 'Minh Quang',
                'bride_name' => 'Thu Hà',
                'slug' => 'minh-quang-thu-ha-2025',
                'template_view' => 'templates.modern_01',
                'tier' => WeddingTier::STANDARD,
            ],
            // Elegant 02
            [
                'groom_name' => 'Đức Long',
                'bride_name' => 'Ngọc Ánh',
                'slug' => 'duc-long-ngoc-anh-2025',
                'template_view' => 'templates.elegant_02',
                'tier' => WeddingTier::STANDARD,
            ],
            // Minimal 03
            [
                'groom_name' => 'Hoàng Anh',
                'bride_name' => 'Minh Châu',
                'slug' => 'hoang-anh-minh-chau-2025',
                'template_view' => 'templates.minimal_03',
                'tier' => WeddingTier::STANDARD,
            ],
            // Traditional Red
            [
                'groom_name' => 'Văn Hùng',
                'bride_name' => 'Thanh Tâm',
                'slug' => 'van-hung-thanh-tam-2025',
                'template_view' => 'templates.traditional_red',
                'tier' => WeddingTier::STANDARD,
            ],
            // Luxury Gold Wedding - PRO
            [
                'groom_name' => 'Quốc Bảo',
                'bride_name' => 'Kim Ngân',
                'slug' => 'quoc-bao-kim-ngan-2025',
                'template_view' => 'templates.luxury_gold',
                'tier' => WeddingTier::PRO,
                'falling_effect' => \App\Enums\FallingEffect::STARS,
            ],
            // Cherry Blossom - PRO
            [
                'groom_name' => 'Nhật Minh',
                'bride_name' => 'Thảo Nhi',
                'slug' => 'nhat-minh-thao-nhi-2025',
                'template_view' => 'templates.cherry_blossom',
                'tier' => WeddingTier::PRO,
                'falling_effect' => \App\Enums\FallingEffect::PETALS,
            ],
            // Galaxy Dreams - PRO
            [
                'groom_name' => 'Tuấn Kiệt',
                'bride_name' => 'Phương Thảo',
                'slug' => 'tuan-kiet-phuong-thao-2025',
                'template_view' => 'templates.galaxy_dreams',
                'tier' => WeddingTier::PRO,
                'falling_effect' => \App\Enums\FallingEffect::SHOOTING_STARS,
            ],
        ];

        foreach ($demoWeddings as $weddingData) {
            $template = Template::where('view_path', $weddingData['template_view'])->first();
            
            if (!$template) {
                $this->command->warn("   ⚠ Template not found: {$weddingData['template_view']}");
                continue;
            }

            $commonMap = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.096814183571!2d105.8501760750486!3d21.02881188778641!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab953357c995%3A0x6c23ce54582e043f!2zTmjDoCBIw6F0IEzhu5tuIEjDoCBO4buZaSAoItObaCBIw6F0Iik!5e0!3m2!1svi!2s!4v1703649999999!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
            
            $eventDate = now()->addDays(15);
            $ceremonyDate = $eventDate->copy(); // Same day ceremony

            Wedding::updateOrCreate(
                ['slug' => $weddingData['slug']],
                [
                    'groom_name' => $weddingData['groom_name'],
                    'bride_name' => $weddingData['bride_name'],
                    'template_id' => $template->id,
                    'template_view' => $weddingData['template_view'],
                    'tier' => $weddingData['tier'],
                    'falling_effect' => $weddingData['falling_effect'] ?? \App\Enums\FallingEffect::HEARTS,
                    
                    // Dates
                    'event_date' => $eventDate->format('Y-m-d'),
                    'event_date_lunar' => '15/12/2025 (Ất Tỵ)', // Demo lunar date
                    
                    // Groom Family
                    'groom_father' => 'Ông Nguyễn Văn Hùng',
                    'groom_mother' => 'Bà Lê Thị Lan',
                    'groom_address' => 'Số 123, Phố Huế, Quận Hai Bà Trưng, Hà Nội',
                    'groom_ceremony_date' => $ceremonyDate->format('Y-m-d'),
                    'groom_ceremony_time' => '09:00:00',
                    'groom_reception_time' => '11:00:00',
                    'groom_reception_venue' => 'Khách sạn Melia Hà Nội',
                    'groom_reception_address' => '44B Lý Thường Kiệt, Hoàn Kiếm, Hà Nội',
                    'groom_map_iframe' => $commonMap,
                    
                    // Bride Family
                    'bride_father' => 'Ông Trần Văn Minh',
                    'bride_mother' => 'Bà Phạm Thị Huệ',
                    'bride_address' => 'Số 456, Đường Láng, Quận Đống Đa, Hà Nội',
                    'bride_ceremony_date' => $ceremonyDate->format('Y-m-d'),
                    'bride_ceremony_time' => '09:00:00',
                    'bride_reception_time' => '11:00:00',
                    'bride_reception_venue' => 'Trống Đồng Palace',
                    'bride_reception_address' => '173 Trường Chinh, Thanh Xuân, Hà Nội',
                    'bride_map_iframe' => $commonMap,
                    
                    // Settings
                    'status' => WeddingStatus::PUBLISHED,
                    'is_active' => true,
                    'is_demo' => true,
                    'show_preload' => true,
                    
                    // Content JSON
                    'content' => [
                        'message' => 'Yêu thương và trân trọng kính mời Quý khách vui lòng dành chút thời gian quý báu đến tham dự buổi tiệc chung vui cùng gia đình chúng tôi.',
                        'love_story' => 'Tình yêu không phải là tìm thấy một người hoàn hảo, mà là học cách nhìn thấy những điều tuyệt vời từ một người không hoàn hảo. Chúng mình đã cùng nhau đi qua những ngày nắng đẹp và cả những ngày mưa giông, để hôm nay, câu chuyện tình yêu ấy được viết tiếp bằng một đám cưới hạnh phúc.',
                        'bank_info' => [
                            ['bank' => 'Vietcombank', 'number' => '999988886666', 'name' => 'NGUYEN VAN GROOM', 'branch' => 'Hanoi'],
                            ['bank' => 'Techcombank', 'number' => '111122223333', 'name' => 'TRAN THI BRIDE', 'branch' => 'Hanoi'],
                        ],
                        'countdown_enabled' => true,
                        'music_enabled' => true,
                    ],
                ]
            );

            $this->command->info("   ✓ {$weddingData['groom_name']} & {$weddingData['bride_name']} ({$weddingData['template_view']})");
        }
    }
}
