<?php

namespace App\Mail;

use App\Models\DataRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DataRequestProcessed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public DataRequest $request, public string $name)
    {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Data Request Processed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.new',
            with: [
                'request' => $this->request,
                'name' => $this->name,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        info("Attachments");
        $dataRequest = $this->request;
        $creatorID = $dataRequest->created_by;
        $exportDir = "downloads/$creatorID/";

        $filenames = scandir($exportDir);

        $attachments = array();

        foreach ($filenames as $filename) {
            if ($filename != "." && $filename != "..") {
                $attachments[] = $exportDir . $filename;
            }
        }
        return $attachments;
    }
}
