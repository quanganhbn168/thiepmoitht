<?php

namespace Database\Seeders;

use App\Models\Reunion;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $templateId = Template::where('view_path', 'templates.que-vo-2')->value('id')
            ?? Template::where('type', 'reunion')->value('id');

        Reunion::updateOrCreate(
            ['slug' => 'hop-lop-nien-khoa-2003-2006-que-vo-2'],
            [
                'user_id' => User::query()->value('id'),
                'template_id' => $templateId,
                'school_name' => 'THPT Quế Võ 2',
                'class_name' => 'Niên Khóa 2003-2006',
                'graduation_year' => '2006',
                'status' => 'published',
                'is_demo' => true,
                'is_active' => true,
            ]
        );
    }
}
