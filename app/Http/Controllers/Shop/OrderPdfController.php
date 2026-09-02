<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SettingsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderPdfController extends Controller
{
    public function __construct(private readonly SettingsService $settingsService) {}

    public function invoice(Order $order)
    {
        Carbon::setLocale('fr');
        $order->load('items');
        $settings = $this->settingsService->current();

        $pdf = Pdf::loadView('pdf.invoice', compact('order', 'settings'));

        return $pdf->stream("facture-{$order->order_number}.pdf");
    }

    public function receipt(Order $order)
    {
        abort_unless($order->paid_at, 404, "Aucun reçu n'est disponible tant que la commande n'est pas payée.");

        Carbon::setLocale('fr');
        $order->load('items');
        $settings = $this->settingsService->current();

        $pdf = Pdf::loadView('pdf.receipt', compact('order', 'settings'));

        return $pdf->stream("recu-{$order->order_number}.pdf");
    }
}
