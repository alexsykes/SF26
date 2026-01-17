<?php

namespace App\Events;

use App\Mail\DataRequestReceived;
use App\Models\DataRequest;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DataRequestOpened
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(DataRequest $dataRequest)
    {
        //
        info("DataRequestOpened");
        $user = User::find($dataRequest->created_by);
        $username = $user->name;
        $email = $user->email;
        $to = new Address($email, $username);
        $bcc = new Address('info@slopefinder.uk', "SlopeFinder UK Admin");

        Mail::to($to)->send(new DataRequestReceived($username));
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
