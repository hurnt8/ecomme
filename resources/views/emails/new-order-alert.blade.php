<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouvelle commande</title>
</head>
<body style="font-family: Arial, sans-serif; color:#222; max-width:600px; margin:0 auto;">
    <h1 style="font-size:18px;">Neue Bestellung {{ $order->order_number }}</h1>
    <p>{{ $order->customer_name }} ({{ $order->customer_email }}) hat soeben eine Bestellung über {{ number_format((float) $order->total, 2) }}&nbsp;€.</p>

    <table style="width:100%;border-collapse:collapse;margin-top:15px;">
        <thead>
            <tr>
                <th style="text-align:left;border-bottom:1px solid #ddd;padding:6px 0;">Artikel</th>
                <th style="text-align:right;border-bottom:1px solid #ddd;padding:6px 0;">Menge</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td style="padding:6px 0;border-bottom:1px solid #eee;">{{ $item->product_name }}</td>
                    <td style="text-align:right;padding:6px 0;border-bottom:1px solid #eee;">{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:15px;">Lieferanschrift: <br><span style="white-space:pre-line;">{{ $order->shipping_address }}</span> ({{ $order->country }})</p>
</body>
</html>
