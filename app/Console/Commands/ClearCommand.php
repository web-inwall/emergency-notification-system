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
        $this->call('view:clear');
        $this->call('view:cache');


        $this->info('Routes, Cache, Config and Views cleared successfully!');
    }
}
