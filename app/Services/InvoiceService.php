<?php

namespace App\Services;

use App\Models\Order;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class InvoiceService
{
    public function generateInvoice(Order $order): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = View::make('invoices.order', [
            'order' => $order->load(['items.product', 'user', 'team']),
            'billingAddress' => $order->billing_address,
            'shippingAddress' => $order->shipping_address,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "invoice-{$order->order_number}.pdf";
        $path = "invoices/{$filename}";

        Storage::disk('public')->put($path, $dompdf->output());

        return $path;
    }

    public function downloadInvoice(Order $order): string
    {
        $path = $this->generateInvoice($order);
        
        return Storage::disk('public')->path($path);
    }

    public function getInvoiceUrl(Order $order): string
    {
        $path = "invoices/invoice-{$order->order_number}.pdf";
        
        if (!Storage::disk('public')->exists($path)) {
            $this->generateInvoice($order);
        }

        return Storage::disk('public')->url($path);
    }

    public function streamInvoice(Order $order): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = View::make('invoices.order', [
            'order' => $order->load(['items.product', 'user', 'team']),
            'billingAddress' => $order->billing_address,
            'shippingAddress' => $order->shipping_address,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
