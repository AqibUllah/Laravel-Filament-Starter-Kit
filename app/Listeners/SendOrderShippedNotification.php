<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;

class SendOrderShippedNotification
{
    public function handle(OrderShipped $event): void
    {
        $order = $event->order;

        if ($order->user) {
            try {
                $template = EmailTemplate::findEmailByKey('order-shipped', null, $order->team_id);
                
                // Prepare template data
                $data = (object) [
                    'order' => $order,
                    'customerName' => $order->user?->name ?? 'Valued Customer',
                    'trackingNumber' => $order->tracking_id ?? 'N/A',
                    'carrier' => $order->carrier ?? 'Standard Shipping',
                    'trackingUrl' => $order->tracking_url ?? '#',
                    'deliveryDays' => '3-5',
                ];

                // Send email using template
                Mail::to($order->user->email)->send($template->getMailableClass()($data));
                
            } catch (\Exception $e) {
                // Log error or handle fallback
                \Log::error('Failed to send order shipped email: ' . $e->getMessage());
            }
        }
    }
}
