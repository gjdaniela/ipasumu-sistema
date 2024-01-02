<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendUpdatedData extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public $newdata;
    public $temats;

            public function __construct(array $data, array $newdata, array $temats)
    {
        $this->data = $data;
        $this->newdata = $newdata;
         $this->temats = $temats;

    }

    public function build()
    {
        return $this->subject('Rediģets īpašuma ieraksts')
                    ->view('pages.epasti.UpdatedData')
                   ->with([
                    'data' => $this->data,
                    'newdata' => $this->newdata,
                    'temats'=> $this -> temats,
                ]);
    }


    /**
     * Get the message envelope.
     */
    /*public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Updated Data',
        );
    }

    /**
     * Get the message content definition.
     */
     /*
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
