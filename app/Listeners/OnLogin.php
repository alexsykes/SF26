<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

class OnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        Log::info('User with ID '.$user->id.' successfully logged in.');
    }
}
