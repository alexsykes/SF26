<?php

namespace App\Listeners;

use App\Events\NewUserRegistration;

class OnNewUserRegistration
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserRegistration $newUserRegistration): void
    {
        info("OnNewUserRegistration called");
        $user = $newUserRegistration->user;
        info("Email:" . $user['email']);
    }

}
