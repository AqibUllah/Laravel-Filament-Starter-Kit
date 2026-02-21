<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\EmailTemplate;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Mail;

class SendOrderPaidNotification
{
    public function __construct(
        private InvoiceService $invoiceService
    ) {}

    public function handle(OrderPaid $event): void
    {
        $order = $event->order;

        // Generate invoice first
        $this->invoiceService->generateInvoice($order);

        // Send email using template system
        if ($order->user) {
            try {
                $template = EmailTemplate::findEmailByKey('order-paid', null, $order->team_id);
                
                // Prepare template data
                $data = (object) [
                    'order' => $order,
                    'customerName' => $order->user?->name ?? 'Valued Customer',
                    'orderTotal' => $order->getFormattedTotalAmount(),
                    'orderUrl' => route('orders.show', $order->id),
                    'orderNotes' => $order->notes ? 
                        "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                            <strong>Additional Notes:</strong>
                            <p>{$order->notes}</p>
                        </div>" : '',
                    'orderItems' => $this->generateOrderItemsTable($order),
                ];

                // Send email using template
                Mail::to($order->user->email)->send($template->getMailableClass()($data));
                
            } catch (\Exception $e) {
                // Fallback to manual email if template not found
                Mail::to($order->user->email)->send(new \App\Mail\OrderPaidMail($order));
            }
        }
    }

    private function generateOrderItemsTable($order): string
    {
        $html = '';
        foreach ($order->items as $item) {
            $html .= "
                <tr>
                    <td style='padding: 10px;'>{$item->product_name}</td>
                    <td style='padding: 10px; text-align: center;'>{$item->quantity}</td>
                    <td style='padding: 10px; text-align: right;'>{$item->getFormattedProductPrice()}</td>
                    <td style='padding: 10px; text-align: right;'>{$item->getFormattedTotalPrice()}</td>
                </tr>
            ";
        }
        return $html;
    }
}
