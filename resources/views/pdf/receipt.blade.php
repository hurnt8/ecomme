<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu {{ $order->receipt_reference }}</title>
    {{-- Same sheet as the invoice, so the two documents a customer receives look like they come
         from the same shop. DejaVu Sans carries U+20AC, so amounts use the € sign. --}}
    <style>
        @page { margin: 26mm 18mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #232323; line-height: 1.5; }
        .muted { color: #8a8a8a; }
        .right { text-align: right; }
        .layout { width: 100%; border-collapse: collapse; }
        .layout td { border: none; padding: 0; vertical-align: top; }

        .brand { font-size: 17px; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; }
        .doc-type { font-size: 22px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; color: #c90000; }
        .doc-meta { margin-top: 4px; }
        .doc-meta strong { font-size: 13px; letter-spacing: 1px; }

        .rule { height: 2px; background: #c90000; margin: 14px 0 20px; font-size: 0; line-height: 0; }

        .panel { background: #f7f7f5; padding: 12px 14px; }
        .panel-title { font-size: 9px; letter-spacing: 1.5px; text-transform: uppercase; color: #8a8a8a; margin-bottom: 6px; }

        .paid-stamp { display: inline-block; padding: 8px 18px; background: #eef5ec; color: #4a7a44;
                      border: 1px solid #7ba173; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-size: 11px; }

        .items { width: 100%; border-collapse: collapse; margin-top: 24px; }
        .items th { padding: 8px 10px; text-align: left; font-size: 9px; letter-spacing: 1px; text-transform: uppercase;
                    color: #6f6f6f; border-bottom: 2px solid #232323; }
        .items td { padding: 9px 10px; border-bottom: 1px solid #e8e8e8; }
        .items .name { font-weight: bold; }

        .totals { width: 46%; margin-left: 54%; border-collapse: collapse; margin-top: 14px; }
        .totals td { padding: 5px 10px; border: none; }
        .totals .grand td { border-top: 2px solid #232323; font-size: 14px; font-weight: bold; padding-top: 9px; }

        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #e8e8e8; font-size: 9px; color: #8a8a8a; }
    </style>
</head>
<body>
    <table class="layout">
        <tr>
            <td style="width:58%;">
                <div class="brand">{{ $settings->site_name }}</div>
                @if ($settings->contact_address)<div class="muted">{{ $settings->contact_address }}</div>@endif
                @if ($settings->contact_email)<div class="muted">{{ $settings->contact_email }}</div>@endif
                @if ($settings->contact_phone)<div class="muted">{{ $settings->contact_phone }}</div>@endif
            </td>
            <td class="right">
                <div class="doc-type">Reçu</div>
                <div class="doc-meta">
                    <strong>{{ $order->receipt_reference }}</strong><br>
                    <span class="muted">Commande {{ $order->order_number }}</span><br>
                    <span class="muted">Payée le {{ $order->paid_at->translatedFormat('j F Y') }}</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="rule"></div>

    <table class="layout">
        <tr>
            <td style="width:48%;">
                <div class="panel">
                    <div class="panel-title">Client</div>
                    <strong>{{ $order->customer_name }}</strong><br>
                    <span class="muted">{{ $order->customer_email }}</span>
                </div>
            </td>
            <td style="width:4%;"></td>
            <td style="width:48%;" class="right">
                <div class="paid-stamp">Paiement reçu</div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Article</th>
                <th class="right">Prix unitaire</th>
                <th class="right">Qté</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td class="name">{{ $item->product_name }}</td>
                    <td class="right">{{ number_format((float) $item->unit_price, 2, ',', ' ') }}&nbsp;{{ $settings->currency_symbol }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">{{ number_format((float) $item->unit_price * $item->quantity, 2, ',', ' ') }}&nbsp;{{ $settings->currency_symbol }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Sous-total</td>
            <td class="right">{{ number_format((float) $order->subtotal, 2, ',', ' ') }}&nbsp;{{ $settings->currency_symbol }}</td>
        </tr>
        <tr>
            <td>Livraison</td>
            <td class="right">
                {{ (float) $order->shipping === 0.0 ? 'Offerte' : number_format((float) $order->shipping, 2, ',', ' ').' '.$settings->currency_symbol }}
            </td>
        </tr>
        <tr>
            <td>TVA{{ (float) $settings->tax_rate > 0 ? ' ('.rtrim(rtrim(number_format((float) $settings->tax_rate * 100, 1, ',', ' '), '0'), ',').'%)' : '' }}</td>
            <td class="right">{{ number_format((float) $order->tax, 2, ',', ' ') }}&nbsp;{{ $settings->currency_symbol }}</td>
        </tr>
        <tr class="grand">
            <td>Total payé</td>
            <td class="right">{{ number_format((float) $order->total, 2, ',', ' ') }}&nbsp;{{ $settings->currency_symbol }}</td>
        </tr>
    </table>

    <div class="footer">
        {{ $settings->site_name }}@if ($settings->contact_address) — {{ $settings->contact_address }}@endif<br>
        Reçu généré automatiquement, valable sans signature.
    </div>
</body>
</html>
