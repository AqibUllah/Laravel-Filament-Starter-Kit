<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;

class SendOrderCancelledNotification
{
    public function handle(OrderCancelled $event): void
    {
        $order = $event->order;

        if ($order->user) {
            try {
                $template = EmailTemplate::findEmailByKey('order-cancelled', null, $order->team_id);
                
                // Prepare template data
                $data = (object) [
                    'order' => $order,
                    'customerName' => $order->user?->name ?? 'Valued Customer',
                    'cancellationReason' => $event->reason ?: 'Customer request',
                    'refundStatus' => $order->payment_status === 'paid' ? 'Processing' : 'Not applicable',
                    'refundDetails' => $order->payment_status === 'paid' ? 
                        "<p><strong>Refund Information:</strong></p>
                         <p>Your refund of {$order->getFormattedTotalAmount()} will be processed within 5-7 business days.</p>" : '',
                ];

                // Send email using template
                Mail::to($order->user->email)->send($template->getMailableClass()($data));
                
            } catch (\Exception $e) {
                // Log error or handle fallback
                \Log::error('Failed to send order cancelled email: ' . $e->getMessage());
            }
        }
    }
}
