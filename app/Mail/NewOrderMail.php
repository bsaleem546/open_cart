<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mailBody;

    public function __construct($mailBody)
    {
        $this->mailBody = $mailBody;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@thetwinsfurnitures.com', 'New Order Mail')
            ->view('mails.newOrderMail')->with(['message' => $this])->subject('Order Confirmed');
    }
}
