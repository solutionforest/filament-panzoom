<?php

namespace SolutionForest\FilamentPanzoom;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentPanzoomPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-panzoom';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        $plugin = app(static::class);

        if (! $plugin instanceof static) {
            throw new \RuntimeException('Unable to resolve the panzoom plugin.');
        }

        return $plugin;
    }

    public static function get(): static
    {
        $plugin = filament(static::make()->getId());

        if (! $plugin instanceof static) {
            throw new \RuntimeException('Unable to resolve the panzoom plugin.');
        }

        return $plugin;
    }
}
