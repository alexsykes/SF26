<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetForecastOWAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-forecast-o-w-a-p-i';

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

        info("app:get-forecast-o-w-a-p-i started.\n");
    }
}
