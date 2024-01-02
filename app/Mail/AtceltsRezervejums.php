<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AtceltsRezervejums extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

            public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Atcelts rezervējums!')
                    ->view('pages.epasti.RezervacijasAtcelsana')
                    ->with($this->data);
    }

}
