<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu {{ $order->receipt_reference }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 20px; margin-bottom: 0; }
        .muted { color: #777; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 6px 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f5f5f5; text-transform: uppercase; font-size: 10px; letter-spacing: .5px; }
        .text-right { text-align: right; }
        .totals td { border-bottom: none; }
        .totals .grand-total { font-size: 14px; font-weight: bold; border-top: 2px solid #222; }
        .paid-stamp { display: inline-block; margin-top: 15px; padding: 8px 16px; background: #dff0d8; color: #3c763d; border: 1px solid #3c763d; font-weight: bold; }
    </style>
</head>
<body>
    <table style="border:none;margin-top:0;">
        <tr style="border:none;">
            <td style="border:none;width:60%;">
                <h1>{{ $settings->site_name }}</h1>
                @if ($settings->contact_address)<div class="muted">{{ $settings->contact_address }}</div>@endif
                @if ($settings->contact_email)<div class="muted">{{ $settings->contact_email }}</div>@endif
            </td>
            <td style="border:none;text-align:right;">
                <h1>RE&Ccedil;U</h1>
                <div>N&deg; {{ $order->receipt_reference }}</div>
                <div class="muted">Commande {{ $order->order_number }}</div>
                <div class="muted">Payée le {{ $order->paid_at->translatedFormat('d F Y') }}</div>
            </td>
        </tr>
    </table>

    <div class="paid-stamp">Paiement reçu</div>

    <table style="border:none;margin-top:25px;">
        <tr style="border:none;">
            <td style="border:none;width:100%;vertical-align:top;">
                <strong>Client</strong><br>
                {{ $order->customer_name }}<br>
                {{ $order->customer_email }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Article</th>
                <th class="text-right">Prix unitaire</th>
                <th class="text-right">Quantité</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-right">{{ number_format((float) $item->unit_price, 2) }}&nbsp;{{ $settings->currency }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format((float) $item->unit_price * $item->quantity, 2) }}&nbsp;{{ $settings->currency }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals" style="width:40%;margin-left:60%;">
        <tr><td>Sous-total</td><td class="text-right">{{ number_format((float) $order->subtotal, 2) }}&nbsp;{{ $settings->currency }}</td></tr>
        <tr><td>Livraison</td><td class="text-right">{{ number_format((float) $order->shipping, 2) }}&nbsp;{{ $settings->currency }}</td></tr>
        <tr><td>Taxes</td><td class="text-right">{{ number_format((float) $order->tax, 2) }}&nbsp;{{ $settings->currency }}</td></tr>
        <tr class="grand-total"><td>Total payé</td><td class="text-right">{{ number_format((float) $order->total, 2) }}&nbsp;{{ $settings->currency }}</td></tr>
    </table>

    <p class="muted" style="margin-top:30px;">{{ $settings->site_name }} — Reçu généré automatiquement, sans signature.</p>
</body>
</html>
