<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{

    public function sendInvoice($invoiceId)
    {
        // Fetch invoice data
        $order = Order::findOrFail($invoiceId);
        $order['package'] = Package::findOrFail($order->package_id);
        $order['payment'] = Payment::findOrFail($order->payment_id);
        // dd($order);


        // Generate PDF in memory

        $pdf = Pdf::loadView('invoice/package', compact('order'));
        // dd($order);
        // $pdf->setPaper([0, 0, 612, 625]);
        return $pdf->stream('invoice.pdf');
        // dd($order);

        $pdfContent  = $pdf->output();
        // dd($pdfOutput);
        // Send email with the PDF attachment
        Mail::send('emails.package_invoice', ['order' => $order], function ($message) use ($order, $pdfContent) {
            $message->to($order->email)
                ->subject('Your Invoice')
                ->attachData($pdfContent, "invoice.pdf", [
                    'mime' => 'application/pdf',
                ]);
        });

        return response()->json(['message' => 'Invoice sent successfully']);
    }
}
