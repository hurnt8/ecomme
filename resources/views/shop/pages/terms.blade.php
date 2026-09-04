@extends('layouts.shop')

@section('title', 'Conditions générales de vente')
@section('meta_description', 'Conditions générales de vente de ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="CGV" subtitle="Conditions générales de vente" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>1. Objet</h3>
                        <p>Les présentes conditions générales régissent les ventes réalisées sur le site {{ $settings->site_name }} entre {{ $settings->site_name }} et tout client réalisant un achat.</p>
                    </div>
                    <div class="desc">
                        <h3>2. Produits</h3>
                        <p>Notre catalogue est organisé en cinq univers : Mobilier, Jardin &amp; Extérieur, Décoration, Équipement Maison et Bois &amp; Chauffage. Les produits sont proposés dans la limite des stocks disponibles ; en cas d'indisponibilité après commande, le client en est informé et remboursé le cas échéant. Le bois de chauffage, vendu au stère ou en filets, peut faire l'objet de légères variations d'essence, d'humidité ou de coloris liées à son caractère naturel.</p>
                    </div>
                    <div class="desc">
                        <h3>3. Prix</h3>
                        <p>Les prix sont indiqués en {{ $settings->currency }}, toutes taxes comprises. {{ $settings->site_name }} se réserve le droit de modifier ses prix à tout moment, les articles étant facturés sur la base des tarifs en vigueur au moment de la validation de la commande.</p>
                    </div>
                    <div class="desc">
                        <h3>4. Commande</h3>
                        <p>Toute commande implique l'acceptation pleine et entière des présentes conditions générales de vente. La commande n'est définitive qu'après confirmation par e-mail et validation du paiement.</p>
                    </div>
                    <div class="desc">
                        <h3>5. Paiement</h3>
                        <p>Le règlement s'effectue par virement bancaire, selon les modalités décrites sur notre page <a href="{{ url('/moyens-paiement') }}">Moyens de paiement</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>6. Livraison</h3>
                        <p>Les modalités et délais de livraison sont détaillés sur notre page <a href="{{ url('/livraison') }}">Livraison</a>. Le bois de chauffage et les articles volumineux font l'objet de modalités de livraison spécifiques (transporteur dédié, rendez-vous préalable).</p>
                    </div>
                    <div class="desc">
                        <h3>7. Droit de rétractation</h3>
                        <p>Conformément à la loi, vous disposez d'un délai de 14 jours pour exercer votre droit de rétractation. Les modalités et exceptions (notamment pour le bois de chauffage entamé) sont détaillées sur notre page <a href="{{ url('/retours') }}">Retours</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>8. Garanties</h3>
                        <p>Tous nos articles bénéficient de la garantie légale de conformité et de la garantie contre les vices cachés, dans les conditions prévues par le Code civil et le Code de la consommation.</p>
                    </div>
                    <div class="desc">
                        <h3>9. Responsabilité</h3>
                        <p>{{ $settings->site_name }} ne saurait être tenu responsable des dommages résultant d'une mauvaise utilisation du produit acheté (notamment d'un appareil de chauffage ou de combustion) ou d'un cas de force majeure.</p>
                    </div>
                    <div class="desc">
                        <h3>10. Droit applicable</h3>
                        <p>Les présentes conditions générales de vente sont soumises au droit français. En cas de litige, une solution amiable sera recherchée avant toute action judiciaire.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
