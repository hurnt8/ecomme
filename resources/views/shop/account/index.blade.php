@extends('layouts.shop')

@section('title', 'Mein Konto')

@section('content')
    <x-shop.page-hero title="Mein Konto" :subtitle="auth()->user()->name" image="hero-maison.jpg" />

    <div id="fh5co-product">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <p style="margin-bottom:20px;">
                        <a href="{{ route('account.profile') }}">Profil bearbeiten</a>
                        &middot;
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-link" style="background:none;border:none;padding:0;color:var(--shop-accent);cursor:pointer;">Abmelden</button>
                        </form>
                    </p>

                    <h3>Meine Bestellungen</h3>

                    @if ($orders->isEmpty())
                        <p>Sie haben noch keine Bestellung aufgegeben. <a href="{{ route('catalog') }}">Shop entdecken</a>.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bestellung</th>
                                    <th>Datum</th>
                                    <th>Status</th>
                                    <th class="text-right">Gesamt</th>
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
                                            <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.invoice', ['order' => $order->order_number]) }}" target="_blank">Rechnung</a>
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
