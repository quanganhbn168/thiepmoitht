<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use App\Support\TemplateViewRegistry;

class SyncTemplates extends Command
{
    protected $signature = 'templates:sync {--force : Force refresh all templates}';
    protected $description = 'Auto-scan template files and sync to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Auto-scanning templates...');

        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach (TemplateViewRegistry::all() as $metadata) {
            $template = Template::where('view_path', $metadata['view_path'])->first();

            if ($template) {
                if ($this->option('force')) {
                    $template->update([
                        'name' => $metadata['name'],
                        'type' => $metadata['type'],
                        'required_tier' => $metadata['required_tier'],
                    ]);
                    $this->line("✏️  Updated: {$metadata['name']} ({$metadata['view_path']})");
                    $updated++;
                } else {
                    $skipped++;
                }
            } else {
                Template::create($metadata);
                $this->line("✅ Created: {$metadata['name']} ({$metadata['view_path']})");
                $created++;
            }
        }

        $this->newLine();
        $this->info("📊 Summary: {$created} created, {$updated} updated, {$skipped} skipped");
        $this->info("🎉 Templates sync completed!");

        return Command::SUCCESS;
    }
}
