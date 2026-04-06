<?php

namespace App\Events;

use App\Models\DataRequest;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use \App\Mail\DataRequestRefused;
use Illuminate\Support\Facades\Mail;

class DataRequestRefusedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public DataRequest $dataRequest)
    {
        info('Event: DataRequestRefused: '.$dataRequest->id);

        $user = User::find($dataRequest->created_by);
        $username = $user->name;
        $email = $user->email;
        $to = new Address($email, $username);
        $bcc = new Address('info@slopefinder.uk', 'SlopeFinder UK Admin');

        Mail::to($to)
            ->bcc($bcc)
            ->send(new DataRequestRefused($this->dataRequest, $username));
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
