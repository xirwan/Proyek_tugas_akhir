<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\MemberScheduleMonthly;

class ScheduleAssigned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $schedules;
    public function __construct($schedulesForEmail)
    {
        $this->schedules = $schedulesForEmail;
    }
    public function build()
    {
        return $this->subject('Jadwal Baru untuk Anda') // Subjek email
                    ->view('emails.schedule_assigned'); // Tampilan email
    }
}
