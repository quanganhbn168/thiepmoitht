<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessCard;
use App\Models\Template;

class BusinessCardSeeder extends Seeder
{
    public function run()
    {
        $card = BusinessCard::where('slug', 'tran-quang-anh')->first();
        
        if (!$card) {
            $this->command->error('Business Card not found!');
            return;
        }

        $template = Template::where('view_path', 'templates.business.ceo_profile')->first();

        $card->update([
            'name' => 'Trần Quang Anh',
            'title' => 'Founder & CEO',
            'company' => 'TechVision Global',
            'about' => '<p>Với hơn 15 năm kinh nghiệm trong lĩnh vực công nghệ phần mềm và chuyển đổi số, tôi đã dẫn dắt TechVision từ một startup nhỏ thành doanh nghiệp hàng đầu.</p><p>Triết lý của tôi là: <strong>Công nghệ phải phục vụ con người</strong>.</p>',
            'template_id' => $template ? $template->id : $card->template_id,
            'content' => [
                'services' => [
                    [
                        'title' => 'Tư vấn Chuyển đổi số',
                        'description' => 'Xây dựng lộ trình số hóa toàn diện cho doanh nghiệp SME.',
                        'icon' => 'fas fa-rocket'
                    ],
                    [
                        'title' => 'Phát triển Phần mềm',
                        'description' => 'Gia công phần mềm chất lượng cao, chuẩn quốc tế.',
                        'icon' => 'fas fa-code'
                    ],
                    [
                        'title' => 'Đầu tư Thiên thần',
                        'description' => 'Hỗ trợ vốn và mentorship cho các startup tiềm năng.',
                        'icon' => 'fas fa-hand-holding-usd'
                    ]
                ],
                'experience' => [
                    [
                        'year' => '2023 - Nay',
                        'title' => 'CEO & Founder',
                        'company' => 'TechVision Global',
                        'description' => 'Điều hành và phát triển chiến lược.'
                    ],
                    [
                        'year' => '2018 - 2023',
                        'title' => 'CTO',
                        'company' => 'VinaSoft Corp',
                        'description' => 'Chịu trách nhiệm toàn bộ mảng công nghệ.'
                    ],
                    [
                        'year' => '2015 - 2018',
                        'title' => 'Senior Developer',
                        'company' => 'Global Outsourcing',
                        'description' => 'Team Leader dự án Fintech.'
                    ]
                ]
            ],
            'social_links' => [
                ['platform' => 'facebook', 'url' => 'https://facebook.com', 'label' => 'Facebook'],
                ['platform' => 'linkedin', 'url' => 'https://linkedin.com', 'label' => 'LinkedIn'],
                ['platform' => 'zalo', 'url' => 'https://zalo.me', 'label' => 'Zalo']
            ]
        ]);

        $this->command->info('Business Card seeded successfully!');
    }
}
