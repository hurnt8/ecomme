<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Confirmation de commande</title>
</head>
<body style="font-family: Arial, sans-serif; color:#222; max-width:600px; margin:0 auto;">
    <h1 style="font-size:20px;">Merci pour votre commande, {{ $order->customer_name }} !</h1>
    <p>Votre commande <strong>{{ $order->order_number }}</strong> a bien été enregistrée le {{ $order->created_at->translatedFormat('d F Y à H:i') }}.</p>

    <table style="width:100%;border-collapse:collapse;margin-top:15px;">
        <thead>
            <tr>
                <th style="text-align:left;border-bottom:1px solid #ddd;padding:6px 0;">Article</th>
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
        Sous-total : {{ number_format((float) $order->subtotal, 2) }}&nbsp;€<br>
        Livraison : {{ number_format((float) $order->shipping, 2) }}&nbsp;€<br>
        Taxes : {{ number_format((float) $order->tax, 2) }}&nbsp;€<br>
        <strong>Total : {{ number_format((float) $order->total, 2) }}&nbsp;€</strong>
    </p>

    <p><a href="{{ $invoiceUrl }}" style="display:inline-block;padding:10px 20px;background:#c90000;color:#fff;text-decoration:none;">Télécharger la facture (PDF)</a></p>

    <h2 style="font-size:16px;margin-top:25px;">Paiement par virement bancaire</h2>
    <p>Merci d'effectuer un virement du montant total ci-dessus en indiquant la référence <strong>{{ $order->order_number }}</strong>. Votre commande sera préparée dès réception et validation du virement.</p>

    {{-- The bank details were missing here: the mail asked for a transfer without saying where to.
         A customer who closes the confirmation page has nothing left to pay with, so they are
         repeated in the mail. Hidden entirely when no IBAN is on file, rather than printing an
         empty "IBAN:" line. --}}
    @if ($settings->bank_iban)
        <table style="border-collapse:collapse;margin:14px 0;font-size:14px;">
            @if ($settings->bank_account_holder)
                <tr>
                    <td style="padding:3px 16px 3px 0;color:#777;">Titulaire</td>
                    <td style="padding:3px 0;">{{ $settings->bank_account_holder }}</td>
                </tr>
            @endif
            @if ($settings->bank_name)
                <tr>
                    <td style="padding:3px 16px 3px 0;color:#777;">Banque</td>
                    <td style="padding:3px 0;">{{ $settings->bank_name }}</td>
                </tr>
            @endif
            <tr>
                <td style="padding:3px 16px 3px 0;color:#777;">IBAN</td>
                <td style="padding:3px 0;font-family:monospace;"><strong>{{ $settings->bank_iban }}</strong></td>
            </tr>
            @if ($settings->bank_bic)
                <tr>
                    <td style="padding:3px 16px 3px 0;color:#777;">BIC</td>
                    <td style="padding:3px 0;font-family:monospace;">{{ $settings->bank_bic }}</td>
                </tr>
            @endif
        </table>
    @endif

    <p style="color:#777;font-size:13px;">
        Vous pouvez suivre l'état de votre commande à tout moment sur notre page de suivi de commande, avec votre
        numéro de commande et votre e-mail.
    </p>
</body>
</html>
