<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCommand extends Command
{
    protected $signature = 'clear';
    protected $description = 'Clear routes, cache, and config';

    public function handle()
    {
        $this->call('route:clear');
        $this->call('cache:clear');
        $this->call('config:clear');

        $this->info('Routes, Cache, and Config cleared successfully!');
    }
}
