@extends('layouts.shop')

@section('title', 'Conditions générales de vente')
@section('meta_description', 'Conditions générales de vente de ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="CGV" subtitle="Conditions générales de vente" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>1. Objet</h3>
                        <p>Les présentes conditions générales régissent les ventes réalisées sur le site {{ $settings->site_name }} entre {{ $settings->site_name }} et tout client réalisant un achat.</p>
                    </div>
                    <div class="desc">
                        <h3>2. Prix</h3>
                        <p>Les prix sont indiqués en {{ $settings->currency }}, toutes taxes comprises. {{ $settings->site_name }} se réserve le droit de modifier ses prix à tout moment, les articles étant facturés sur la base des tarifs en vigueur au moment de la validation de la commande.</p>
                    </div>
                    <div class="desc">
                        <h3>3. Commande</h3>
                        <p>Toute commande implique l'acceptation pleine et entière des présentes conditions générales de vente. La commande n'est définitive qu'après confirmation par e-mail et validation du paiement.</p>
                    </div>
                    <div class="desc">
                        <h3>4. Paiement</h3>
                        <p>Le règlement s'effectue par virement bancaire, selon les modalités décrites sur notre page <a href="{{ url('/moyens-paiement') }}">Moyens de paiement</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>5. Livraison</h3>
                        <p>Les modalités et délais de livraison sont détaillés sur notre page <a href="{{ url('/livraison') }}">Livraison</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>6. Droit de rétractation</h3>
                        <p>Conformément à la loi, vous disposez d'un délai de 14 jours pour exercer votre droit de rétractation. Les modalités sont détaillées sur notre page <a href="{{ url('/retours') }}">Retours</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>7. Garanties</h3>
                        <p>Tous nos articles bénéficient de la garantie légale de conformité et de la garantie contre les vices cachés, dans les conditions prévues par le Code civil et le Code de la consommation.</p>
                    </div>
                    <div class="desc">
                        <h3>8. Responsabilité</h3>
                        <p>{{ $settings->site_name }} ne saurait être tenu responsable des dommages résultant d'une mauvaise utilisation du produit acheté ou d'un cas de force majeure.</p>
                    </div>
                    <div class="desc">
                        <h3>9. Droit applicable</h3>
                        <p>Les présentes conditions générales de vente sont soumises au droit français. En cas de litige, une solution amiable sera recherchée avant toute action judiciaire.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
