<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvoiceService
{
    /**
     * Generate and send an invoice as a PDF
     */
    public function generateAndSendInvoice($order)
    {
        Log::info('send email', ['order' => $order]);
        // Generate PDF
        $pdf = Pdf::loadView('invoice.package', ['order' => $order]);


        // Send the PDF via email
        Log::info('Generated and sent invoice for order ID: ' . $pdf);
        $this->sendInvoiceEmail($order, $pdf);

        return true;
    }


    /**
     * Send invoice email
     */
    protected function sendInvoiceEmail($invoiceData, $pdf)
    {
        Mail::send('emails.package_invoice', compact('invoiceData'), function ($message) use ($invoiceData, $pdf) {
            $message->to($invoiceData->email)
                ->subject('Your Invoice')
                ->attachData($pdf, "invoice_{$invoiceData->id}.pdf", [
                    'mime' => 'application/pdf',
                ]);
        });
    }
}
