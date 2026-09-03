@extends('layouts.shop')

@section('title', 'Aide / FAQ')
@section('meta_description', 'Questions fréquentes sur les commandes, la livraison, les retours et le paiement chez ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Aide" subtitle="Questions fréquentes" image="img_bg_1.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Comment passer commande ?</h3>
                        <p>Ajoutez les articles souhaités à votre panier, puis suivez le tunnel de commande : coordonnées, adresse de livraison, choix du pays et validation. Aucun compte n'est requis pour commander.</p>
                    </div>
                    <div class="desc">
                        <h3>Quels sont les délais et frais de livraison ?</h3>
                        <p>La livraison est offerte à partir de {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency }} d'achat en zone euro. Hors zone euro, des frais supplémentaires s'appliquent. Détails sur notre page <a href="{{ url('/livraison') }}">Livraison</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>Comment suivre ma commande ?</h3>
                        <p>Rendez-vous sur notre page <a href="{{ route('tracking.index') }}">Suivi de commande</a> avec votre numéro de commande et votre e-mail.</p>
                    </div>
                    <div class="desc">
                        <h3>Comment payer ma commande ?</h3>
                        <p>Le règlement s'effectue par virement bancaire. Les coordonnées bancaires vous sont communiquées sur la page de confirmation et par e-mail. Détails sur notre page <a href="{{ url('/moyens-paiement') }}">Moyens de paiement</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>Puis-je retourner un article ?</h3>
                        <p>Oui, dans les conditions décrites sur notre page <a href="{{ url('/retours') }}">Retours</a>. Le bois de chauffage entamé ou livré en vrac ne peut toutefois pas être repris, pour des raisons pratiques et d'hygiène.</p>
                    </div>
                    <div class="desc">
                        <h3>Comment est livré le bois de chauffage ?</h3>
                        <p>Le bois de chauffage est vendu au stère ou en filets, sur palette. En raison du poids et du volume, la livraison de ces produits peut nécessiter une prise de rendez-vous et se fait au pied de l'immeuble ou de la propriété (le transporteur ne monte pas les étages). Voir notre page <a href="{{ url('/livraison') }}">Livraison</a> pour le détail.</p>
                    </div>
                    <div class="desc">
                        <h3>Le mobilier de jardin résiste-t-il aux intempéries ?</h3>
                        <p>Nos références Jardin &amp; Extérieur sont sélectionnées pour un usage extérieur (bois traité, résine tressée, métal thermolaqué). Chaque fiche produit précise les matériaux et l'entretien recommandé avant l'hiver.</p>
                    </div>
                    <div class="desc">
                        <h3>Proposez-vous des devis pour les professionnels ou les grosses quantités ?</h3>
                        <p>Oui, notamment pour les commandes de bois de chauffage en volume ou l'équipement d'un commerce. Contactez-nous via le <a href="{{ route('contact.index') }}">formulaire de contact</a> en précisant votre besoin.</p>
                    </div>
                    <div class="desc">
                        <h3>Une autre question ?</h3>
                        <p>Notre équipe vous répond via le <a href="{{ route('contact.index') }}">formulaire de contact</a>
                            @if ($settings->whatsapp_number)
                                ou par WhatsApp.
                            @else
                                .
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
