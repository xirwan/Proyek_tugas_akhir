<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Activity;


class RegistrationSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public $activity;
    

    /**
     * Create a new message instance.
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Kegiatan Berhasil')
                    ->view('emails.registration_successful');
    }
}
