<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrateWelcomeDemosSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TemplateSeeder::class);
    }
}
