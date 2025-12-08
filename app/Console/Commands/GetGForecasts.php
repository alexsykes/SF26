<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetGForecasts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-g-forecasts';

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
        info("app:get-g-forecasts started.");
    }
}
