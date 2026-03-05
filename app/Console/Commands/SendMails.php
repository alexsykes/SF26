<?php

namespace App\Console\Commands;

use App\Mail\SiteAnnouncement;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $users = DB::table('users_copy')
            ->select('name', 'email')
            ->whereNotNull('email')
            ->get();

        foreach ($users as $user) {
            $email = $user->email;
            $name = $user->name;

            //        $email = "alexs1301@yahoo.com";
            //        $name = "Alex Yahoo";
            $address = new Address($email, $name);
            //            Mail::to($address)->send(new SiteAnnouncement($name));
            info("app:send-mails sent to $name at  $email");
            //        }
        }
    }
}
