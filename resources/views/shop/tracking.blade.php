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
                            <h2>Retrouvez le statut de votre commande avec son numéro et votre e-mail</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form method="POST" action="{{ route('tracking.search') }}">
                        @csrf
                        <div class="form-group">
                            <label for="order_number">Numéro de commande</label>
                            <input type="text" name="order_number" id="order_number" value="{{ old('order_number') }}" class="form-control" placeholder="AM-20260101-XXXX" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail utilisé lors de la commande</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        @error('order_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-outline btn-lg">Suivre ma commande</button>
                    </form>

                    @if ($searched)
                        <div style="margin-top:30px;">
                            @if ($order)
                                <h3>Commande {{ $order->order_number }}</h3>
                                <p>Statut : <strong>{{ $order->status->label() }}</strong></p>
                                <table class="table">
                                    <thead><tr><th>Produit</th><th>Qté</th><th>Total</th></tr></thead>
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
                                <p><strong>Total : {{ number_format((float) $order->total, 2) }}&nbsp;€</strong></p>
                                <p>
                                    <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.invoice', ['order' => $order->order_number]) }}"
                                       class="btn btn-default" target="_blank">
                                        Télécharger la facture
                                    </a>
                                </p>
                            @else
                                <p class="text-danger">Aucune commande ne correspond à ce numéro et cet e-mail. Vérifiez ces informations ou contactez notre service client.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
