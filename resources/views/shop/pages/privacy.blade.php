@extends('layouts.shop')

@section('title', 'Politique de confidentialité')
@section('meta_description', 'Comment ' . $settings->site_name . ' collecte et utilise vos données personnelles.')

@section('content')
    <x-shop.page-hero title="Confidentialité" subtitle="Protection des données personnelles" image="img_bg_4.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Données collectées</h3>
                        <p>Lors d'une commande, nous collectons votre nom, votre adresse e-mail et votre adresse de livraison. Si vous créez un compte, nous conservons également vos identifiants de connexion (mot de passe stocké de façon chiffrée).</p>
                    </div>
                    <div class="desc">
                        <h3>Utilisation des données</h3>
                        <p>Ces données servent exclusivement au traitement de vos commandes, à la communication liée à votre commande (confirmation, suivi, facture) et, si vous y consentez, à notre lettre d'information.</p>
                    </div>
                    <div class="desc">
                        <h3>Conservation</h3>
                        <p>Les données liées à une commande sont conservées le temps nécessaire au respect de nos obligations légales et comptables. Les données d'un compte client sont conservées tant que le compte reste actif.</p>
                    </div>
                    <div class="desc">
                        <h3>Vos droits</h3>
                        <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de rectification et de suppression de vos données. Pour l'exercer, contactez-nous
                            @if ($settings->contact_email)
                                à <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>.
                            @else
                                via notre <a href="{{ route('contact.index') }}">formulaire de contact</a>.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
