<?php

namespace Fawest\Nestedset\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fawest:install-categorize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Categorize package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing migration...');
        $this->callSilent('vendor:publish', ['--tag' => 'fawest-categorize-migrations']);
    }
}
