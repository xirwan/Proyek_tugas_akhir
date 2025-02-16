<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ActivityPayment;

class PaymentRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    /**
     * Create a new message instance.
     */
    public function __construct(ActivityPayment $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject('Status Pembayaran Anda')
                    ->view('emails.payment_rejected');
    }
}
