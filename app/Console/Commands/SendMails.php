<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a batch of emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        info("app:send-mails started.\n");
    }
}
