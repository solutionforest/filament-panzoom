<?php

namespace SolutionForest\FilamentPanzoom\Commands;

use Illuminate\Console\Command;

class FilamentPanzoomCommand extends Command
{
    public $signature = 'filament-panzoom';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
