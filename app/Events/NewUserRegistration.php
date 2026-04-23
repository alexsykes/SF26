<?php

namespace App\Events;

use App\Mail\NewUserRegistered;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewUserRegistration
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public mixed $user;

    /**
     * Create a new event instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
        info("New user: " . $user->email);

        $to = 'alex@alexsykes.net';
        Mail::to($to)
            ->send(new NewUserRegistered($user->name));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
