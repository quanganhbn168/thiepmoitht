<?php

namespace App\Console\Commands;

use App\Models\Wedding;
use App\Helpers\LunarHelper;
use Illuminate\Console\Command;

class UpdateLunarDates extends Command
{
    protected $signature = 'weddings:update-lunar';
    protected $description = 'Update lunar dates for all weddings';

    public function handle()
    {
        $weddings = Wedding::all();
        
        foreach ($weddings as $wedding) {
            if ($wedding->event_date) {
                $lunar = LunarHelper::solarToLunar($wedding->event_date);
                $wedding->event_date_lunar = $lunar;
            }
            
            if ($wedding->reception_date) {
                $lunar = LunarHelper::solarToLunar($wedding->reception_date);
                $wedding->reception_date_lunar = $lunar;
            }
            
            $wedding->saveQuietly(); // Skip model events
            
            $this->info("Updated: {$wedding->groom_name} & {$wedding->bride_name}");
            $this->info("  Event: {$wedding->event_date?->format('d/m/Y')} => {$wedding->event_date_lunar}");
        }
        
        $this->info('Done!');
    }
}
