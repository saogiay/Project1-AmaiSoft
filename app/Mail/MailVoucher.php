<?php

namespace App\Mail;

use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailVoucher extends Mailable
{
    use Queueable, SerializesModels;

    public $vouchers;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vouchers)
    {
        $this->vouchers = $vouchers;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Voucher',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        if ($this->vouchers instanceof Collection) {
            return new Content(
                view: 'emails.voucher',
                with: [
                    'collection' => true
                ]
            );
        } else return new Content(
            view: 'emails.voucher',
            with: [
                'collection' => false
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
