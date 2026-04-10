<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\File;

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
        
        $templatesPath = resource_path('views/templates');
        $created = 0;
        $updated = 0;
        $skipped = 0;
        
        // Scan all .blade.php files in templates directory (not subdirectories - business was removed)
        $files = File::glob($templatesPath . '/*.blade.php');
        
        foreach ($files as $filePath) {
            $filename = basename($filePath, '.blade.php');
            $viewPath = 'templates.' . $filename;
            
            // Extract metadata from blade file
            $metadata = $this->extractMetadata($filePath, $filename);
            
            // Check if template exists in database
            $template = Template::where('view_path', $viewPath)->first();
            
            if ($template) {
                if ($this->option('force')) {
                    $template->update([
                        'name' => $metadata['name'],
                        'type' => 'wedding',
                        'required_tier' => $metadata['tier'],
                    ]);
                    $this->line("✏️  Updated: {$metadata['name']}");
                    $updated++;
                } else {
                    $skipped++;
                }
            } else {
                Template::create([
                    'name' => $metadata['name'],
                    'view_path' => $viewPath,
                    'type' => 'wedding',
                    'required_tier' => $metadata['tier'],
                    'is_active' => true,
                ]);
                $this->line("✅ Created: {$metadata['name']}");
                $created++;
            }
        }
        
        $this->newLine();
        $this->info("📊 Summary: {$created} created, {$updated} updated, {$skipped} skipped");
        $this->info("🎉 Templates sync completed!");
        
        return Command::SUCCESS;
    }
    
    /**
     * Extract template metadata from blade file
     */
    private function extractMetadata(string $filePath, string $filename): array
    {
        $content = File::get($filePath);
        
        // Default name from filename
        $name = str_replace('_', ' ', ucwords($filename, '_'));
        
        // Try to extract name from: {{-- Template Name: Name Here --}}
        if (preg_match('/{{--\s*Template Name:\s*([^-]+)\s*--}}/i', $content, $matches)) {
            $name = trim($matches[1]);
        }
        
        // Try to extract tier from: {{-- Tier: pro --}} or similar
        $tier = 'standard'; // default
        if (preg_match('/{{--\s*Tier:\s*(basic|standard|pro)\s*--}}/i', $content, $matches)) {
            $tier = strtolower(trim($matches[1]));
        } else {
            // Auto-detect tier based on keywords in filename or content
            $lowerFilename = strtolower($filename);
            $lowerContent = strtolower($content);
            
            // Pro tier indicators
            if (str_contains($lowerFilename, 'galaxy') || 
                str_contains($lowerFilename, 'cinematic') || 
                str_contains($lowerFilename, 'cherry') ||
                str_contains($lowerFilename, 'mewedding') ||
                str_contains($lowerFilename, 'luxury') ||
                str_contains($lowerContent, 'preload') && str_contains($lowerContent, 'variant')) {
                $tier = 'pro';
            }
            // Basic tier indicators
            elseif (str_contains($lowerFilename, 'minimal') || 
                    str_contains($lowerFilename, 'simple') ||
                    str_contains($lowerFilename, 'modern') ||
                    str_contains($lowerFilename, 'elegant')) {
                $tier = 'basic';
            }
        }
        
        return [
            'name' => $name,
            'tier' => $tier,
        ];
    }
}

