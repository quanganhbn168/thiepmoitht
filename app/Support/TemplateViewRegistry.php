<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TemplateViewRegistry
{
    private const SUPPORTED_TYPES = [
        'reunion',
        'reunion_teacher',
        'gathering',
        'wedding',
    ];

    private const DIRECTORIES = [
        'templates',
    ];

    public static function all(): array
    {
        $templates = [];

        foreach (self::DIRECTORIES as $directory) {
            foreach (self::scanDirectory($directory) as $viewPath => $filePath) {
                $metadata = self::extractMetadata($filePath, $viewPath);

                if (! $metadata) {
                    continue;
                }

                $templates[$viewPath] = [
                    'name' => $metadata['name'],
                    'view_path' => $viewPath,
                    'type' => $metadata['type'],
                    'required_tier' => 'standard',
                    'is_active' => true,
                ];
            }
        }

        ksort($templates);

        return $templates;
    }

    public static function paths(?string $type = null): array
    {
        return collect(self::all())
            ->when($type, fn ($templates) => $templates->where('type', $type))
            ->pluck('view_path', 'view_path')
            ->all();
    }

    public static function exists(string $viewPath): bool
    {
        return array_key_exists($viewPath, self::all());
    }

    public static function typeForViewPath(string $viewPath): ?string
    {
        return self::all()[$viewPath]['type'] ?? null;
    }

    private static function scanDirectory(string $directory): array
    {
        $paths = [];
        $viewsRoot = str_replace('\\', '/', resource_path('views'));
        $basePath = resource_path('views/'.$directory);

        if (! File::isDirectory($basePath)) {
            return $paths;
        }

        foreach (File::allFiles($basePath) as $file) {
            if (! str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $normalizedPath = str_replace('\\', '/', $file->getPathname());
            $viewPath = str_replace($viewsRoot.'/', '', $normalizedPath);
            $viewPath = preg_replace('/\.blade\.php$/', '', $viewPath);
            $viewPath = str_replace('/', '.', $viewPath);
            $paths[$viewPath] = $file->getPathname();
        }

        return $paths;
    }

    private static function extractMetadata(string $filePath, string $viewPath): ?array
    {
        $content = File::get($filePath);
        $type = self::extractTemplateType($content);

        if (! $type) {
            return null;
        }

        return [
            'name' => self::extractTemplateName($content, $viewPath),
            'type' => $type,
        ];
    }

    private static function extractTemplateName(string $content, string $viewPath): string
    {
        if (preg_match('/{{--\s*Template Name:\s*(.*?)\s*--}}/i', $content, $matches)) {
            return trim($matches[1]);
        }

        return Str::of($viewPath)
            ->afterLast('.')
            ->replace(['-', '_'], ' ')
            ->title()
            ->toString();
    }

    private static function extractTemplateType(string $content): ?string
    {
        if (preg_match('/{{--\s*(?:Template\s*)?Type:\s*([a-z_ -]+)\s*--}}/i', $content, $matches)) {
            $type = str_replace([' ', '-'], '_', strtolower(trim($matches[1])));

            return in_array($type, self::SUPPORTED_TYPES, true) ? $type : null;
        }

        if (Str::contains($content, ["extends('layouts.reunion')", 'extends("layouts.reunion")'])) {
            return 'reunion';
        }

        return null;
    }
}
