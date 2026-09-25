<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Bestellbestätigung</title>
</head>
<body style="font-family: Arial, sans-serif; color:#222; max-width:600px; margin:0 auto;">
    <h1 style="font-size:20px;">Vielen Dank für Ihre Bestellung, {{ $order->customer_name }} !</h1>
    <p>Ihre Bestellung <strong>{{ $order->order_number }}</strong> wurde erfasst am {{ $order->created_at->translatedFormat('d. F Y \u\m H:i') }}.</p>

    <table style="width:100%;border-collapse:collapse;margin-top:15px;">
        <thead>
            <tr>
                <th style="text-align:left;border-bottom:1px solid #ddd;padding:6px 0;">Artikel</th>
                <th style="text-align:right;border-bottom:1px solid #ddd;padding:6px 0;">Qté</th>
                <th style="text-align:right;border-bottom:1px solid #ddd;padding:6px 0;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td style="padding:6px 0;border-bottom:1px solid #eee;">{{ $item->product_name }}</td>
                    <td style="text-align:right;padding:6px 0;border-bottom:1px solid #eee;">{{ $item->quantity }}</td>
                    <td style="text-align:right;padding:6px 0;border-bottom:1px solid #eee;">{{ number_format((float) $item->unit_price * $item->quantity, 2) }}&nbsp;€</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align:right;margin-top:10px;">
        Zwischensumme: {{ number_format((float) $order->subtotal, 2) }}&nbsp;€<br>
        Versand: {{ number_format((float) $order->shipping, 2) }}&nbsp;€<br>
        Taxes : {{ number_format((float) $order->tax, 2) }}&nbsp;€<br>
        <strong>Total : {{ number_format((float) $order->total, 2) }}&nbsp;€</strong>
    </p>

    <p><a href="{{ $invoiceUrl }}" style="display:inline-block;padding:10px 20px;background:#c90000;color:#fff;text-decoration:none;">Rechnung herunterladen (PDF)</a></p>

    <h2 style="font-size:16px;margin-top:25px;">Zahlung per Banküberweisung</h2>
    <p>Bitte überweisen Sie den oben genannten Gesamtbetrag unter Angabe der Referenz <strong>{{ $order->order_number }}</strong>. Ihre Bestellung wird bearbeitet, sobald die Überweisung eingegangen und bestätigt ist.</p>

    <p style="color:#777;font-size:13px;">
        Den Status Ihrer Bestellung können Sie jederzeit auf unserer Seite zur Sendungsverfolgung einsehen, mit Ihrer
        Bestellnummer und Ihrer E-Mail-Adresse.
    </p>
</body>
</html>
