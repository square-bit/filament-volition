<?php

namespace Squarebit\FilamentVolition\Commands;

use Illuminate\Console\Command;

class FilamentVolitionCommand extends Command
{
    public $signature = 'filament-volition';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
