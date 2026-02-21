<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order #{$this->order->order_number} - Payment Confirmed",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.paid',
            with: [
                'order' => $this->order,
                'customerName' => $this->order->user?->name ?? 'Valued Customer',
                'orderTotal' => $this->order->getFormattedTotalAmount(),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
