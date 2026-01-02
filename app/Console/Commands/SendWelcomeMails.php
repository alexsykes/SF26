<?php

namespace App\Console\Commands;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

class SendWelcomeMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-welcome-mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a welcome email to a new user. Also add user as Editor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('isEditor', 0)->get();
        foreach ($users as $user) {
            $email = $user->email;
            $name = $user->name;

            $user->isEditor = 1;
            $user->updated_at = now();
            $user->save();
            info($name . " welcomed and approved");
            Mail::to(new Address($email, $name))->send(new WelcomeMail($name, $email));
        }
    }
}
