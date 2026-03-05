<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateWindDirections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-wind-directions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('app:update-wind-directions started.');
    }
}
