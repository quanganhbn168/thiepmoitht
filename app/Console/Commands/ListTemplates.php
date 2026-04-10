<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;

class ListTemplates extends Command
{
    protected $signature = 'templates:list-debug';
    protected $description = 'List all templates for debugging';

    public function handle()
    {
        $templates = Template::all();
        foreach ($templates as $t) {
            $this->line("ID: {$t->id} | Name: {$t->name} | View: {$t->view_path}");
        }
    }
}
