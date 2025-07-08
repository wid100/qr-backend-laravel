<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CardOrder;

class AdminNewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(CardOrder $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('🛒 New Card Order Received')
            ->view('emails.admin_new_order');
    }
}
