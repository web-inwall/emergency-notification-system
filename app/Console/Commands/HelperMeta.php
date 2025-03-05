<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelperMeta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'helper meta synchronization ';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('ide-helper:meta');
    }
}
