@extends('layouts.shop')

@section('title', 'Mon compte')

@section('content')
    <x-shop.page-hero title="Mon compte" :subtitle="auth()->user()->name" image="img_bg_4.jpg" />

    <div id="fh5co-product">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <p style="margin-bottom:20px;">
                        <a href="{{ route('account.profile') }}">Modifier mon profil</a>
                        &middot;
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-link" style="background:none;border:none;padding:0;color:#d1c286;cursor:pointer;">Se déconnecter</button>
                        </form>
                    </p>

                    <h3>Mes commandes</h3>

                    @if ($orders->isEmpty())
                        <p>Vous n'avez pas encore passé de commande. <a href="{{ route('catalog') }}">Découvrir la boutique</a>.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Commande</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th class="text-right">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $order->status->label() }}</td>
                                        <td class="text-right">{{ number_format((float) $order->total, 2) }}&nbsp;€</td>
                                        <td class="text-right">
                                            <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.invoice', ['order' => $order->order_number]) }}" target="_blank">Facture</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $orders->links('partials.shop.pagination') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
