@extends('layouts.shop')

@section('title', 'Commande confirmée')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('template/images/img_bg_5.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Merci, {{ $order->customer_name }} !</h1>
                            <h2>Votre commande {{ $order->order_number }} est enregistrée</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h3>Récapitulatif</h3>
                    <table class="table">
                        <thead>
                            <tr><th>Produit</th><th>Qté</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format((float) $item->unit_price * $item->quantity, 2) }}&nbsp;€</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>Sous-total <span style="float:right;">{{ number_format((float) $order->subtotal, 2) }}&nbsp;€</span></p>
                    <p>Livraison <span style="float:right;">{{ number_format((float) $order->shipping, 2) }}&nbsp;€</span></p>
                    <p>Taxes <span style="float:right;">{{ number_format((float) $order->tax, 2) }}&nbsp;€</span></p>
                    <p><strong>Total <span style="float:right;">{{ number_format((float) $order->total, 2) }}&nbsp;€</span></strong></p>

                    <p>
                        <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.invoice', ['order' => $order->order_number]) }}"
                           class="btn btn-primary btn-outline btn-lg" target="_blank">
                            Télécharger la facture (PDF)
                        </a>
                    </p>
                </div>

                <div class="col-md-5">
                    <div style="border:1px solid #e5e5e5;padding:25px;" x-data="{ copied: false }">
                        <h3 style="margin-top:0;">Paiement par virement</h3>
                        <p>Merci d'effectuer un virement du montant total ci-dessus en indiquant la référence <strong>{{ $order->order_number }}</strong>. Votre commande sera préparée dès réception et validation du virement.</p>

                        @if ($settings->bank_iban)
                            <p>
                                @if ($settings->bank_account_holder)
                                    Titulaire : {{ $settings->bank_account_holder }}<br>
                                @endif
                                @if ($settings->bank_name)
                                    Banque : {{ $settings->bank_name }}<br>
                                @endif
                                IBAN : <strong>{{ $settings->bank_iban }}</strong>
                                @if ($settings->bank_bic)
                                    <br>BIC : {{ $settings->bank_bic }}
                                @endif
                            </p>
                            <button type="button" class="btn btn-default"
                                    @click="navigator.clipboard.writeText('{{ $settings->bank_iban }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })">
                                <span x-show="!copied">Copier l'IBAN</span>
                                <span x-show="copied" x-cloak>Copié !</span>
                            </button>
                        @endif

                        <p class="text-muted" style="margin-top:20px;">
                            Une facture contenant nos coordonnées bancaires vous a été envoyée par e-mail avec le
                            montant exact à virer.
                        </p>
                    </div>

                    <p style="margin-top:20px;">
                        Vous pourrez suivre l'état de votre commande à tout moment depuis la page
                        <a href="{{ route('tracking.index') }}">Suivi de commande</a> avec votre numéro de commande
                        et votre e-mail.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
