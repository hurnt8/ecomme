@extends('layouts.shop')

@section('title', 'Suivi de commande')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('template/images/img_bg_2.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Suivi de commande</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product" class="tracking">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="tracking-form">
                        <h2>Où en est ma commande&nbsp;?</h2>
                        <p>Saisissez votre numéro de commande et l'e-mail utilisé lors de l'achat.</p>

                        <form method="POST" action="{{ route('tracking.search') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="order_number">Numéro de commande</label>
                                        <input type="text" name="order_number" id="order_number" value="{{ old('order_number') }}" class="form-control" placeholder="AM-20260101-XXXX" required>
                                        @error('order_number')
                                            <small class="tracking-error">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">E-mail de la commande</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                                        @error('email')
                                            <small class="tracking-error">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg tracking-submit">Suivre ma commande</button>
                        </form>
                    </div>

                    @if ($searched)
                        @if ($order)
                            @php
                                $steps = \App\Enums\OrderStatus::trackingSteps();
                                $position = $order->status->trackingPosition();
                                $isCancelled = $order->status === \App\Enums\OrderStatus::Cancelled;
                            @endphp

                            <section class="tracking-result">
                                <header class="tracking-result-header">
                                    <div>
                                        <span class="tracking-result-label">Commande</span>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                    <span class="tracking-badge {{ $isCancelled ? 'is-cancelled' : '' }}">{{ $order->status->label() }}</span>
                                </header>

                                <p class="tracking-placed">
                                    Passée le {{ $order->created_at->translatedFormat('j F Y') }}
                                    @if ($order->paid_at)
                                        · Paiement reçu le {{ $order->paid_at->translatedFormat('j F Y') }}
                                    @endif
                                </p>

                                {{-- A timeline rather than the single line of text this page used to
                                     show: the point of a tracking page is where the order sits on
                                     the path, not just the name of the current state. --}}
                                @if ($isCancelled)
                                    <p class="tracking-cancelled">{{ $order->status->description() }}</p>
                                @else
                                    <ol class="tracking-timeline">
                                        @foreach ($steps as $index => $step)
                                            <li class="{{ $index < $position ? 'is-done' : ($index === $position ? 'is-current' : '') }}">
                                                <span class="tracking-timeline-dot" aria-hidden="true"></span>
                                                <span class="tracking-timeline-body">
                                                    <strong>{{ $step->label() }}</strong>
                                                    @if ($index === $position)
                                                        <small>{{ $step->description() }}</small>
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif

                                <h3>Détail</h3>
                                <ul class="checkout-items">
                                    @foreach ($order->items as $item)
                                        <li>
                                            <span class="checkout-item-image">
                                                <img src="{{ $item->product?->thumbnail_url ?? '' }}" alt="{{ $item->product_name }}">
                                                <span class="checkout-item-qty">{{ $item->quantity }}</span>
                                            </span>
                                            <span class="checkout-item-body">
                                                <span class="checkout-item-name">{{ $item->product_name }}</span>
                                                <small>{{ number_format((float) $item->unit_price, 2) }}&nbsp;{{ $settings->currency_symbol }} l'unité</small>
                                            </span>
                                            <span class="checkout-item-total">{{ number_format((float) $item->unit_price * $item->quantity, 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="checkout-totals">
                                    <div class="checkout-total-row">
                                        <span>Sous-total</span>
                                        <span>{{ number_format((float) $order->subtotal, 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                                    </div>
                                    <div class="checkout-total-row">
                                        <span>Livraison</span>
                                        <span>{{ (float) $order->shipping === 0.0 ? 'Offerte' : number_format((float) $order->shipping, 2).' '.$settings->currency_symbol }}</span>
                                    </div>
                                    <div class="checkout-total-row is-grand">
                                        <span>Total</span>
                                        <span>{{ number_format((float) $order->total, 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                                    </div>
                                </div>

                                <div class="tracking-actions">
                                    <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.invoice', ['order' => $order->order_number]) }}"
                                       class="btn btn-primary btn-outline" target="_blank" rel="noopener">
                                        Télécharger la facture (PDF)
                                    </a>
                                    <a href="{{ route('contact.index') }}" class="tracking-help">Une question sur cette commande&nbsp;?</a>
                                </div>
                            </section>
                        @else
                            <div class="tracking-notfound">
                                <h3>Aucune commande trouvée</h3>
                                <p>
                                    Ce numéro et cet e-mail ne correspondent à aucune commande. Vérifiez le numéro
                                    figurant dans votre e-mail de confirmation — il commence par
                                    <strong>AM-</strong> — et l'adresse utilisée lors de l'achat.
                                </p>
                                <a href="{{ route('contact.index') }}" class="btn btn-primary btn-outline">Contacter le service client</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
