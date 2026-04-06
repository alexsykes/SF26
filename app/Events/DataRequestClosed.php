<?php

namespace App\Events;

use App\Mail\DataRequestProcessed;
use App\Models\DataRequest;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DataRequestClosed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public DataRequest $dataRequest)
    {
        info('Event: DataRequestID: '.$dataRequest->id.' ' . $dataRequest->approved);
        //        dd($dataRequest);
        $user = User::find($dataRequest->created_by);
        $username = $user->name;
        $email = $user->email;
        $to = new Address($email, $username);
        $bcc = new Address('info@slopefinder.uk', 'SlopeFinder UK Admin');
//
        Mail::to($to)
            ->bcc($bcc)
            ->send(new DataRequestProcessed($this->dataRequest, $username));

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
