@extends('layouts.shop')

@section('title', 'Retours')
@section('meta_description', 'Conditions de retour et de remboursement chez ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Retours" image="img_bg_4.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Droit de rétractation</h3>
                        <p>Conformément à la législation en vigueur, vous disposez d'un délai de 14 jours à compter de la réception de votre commande pour exercer votre droit de rétractation, sans avoir à justifier de motif.</p>
                    </div>
                    <div class="desc">
                        <h3>Conditions</h3>
                        <p>L'article doit être retourné dans son état d'origine, non utilisé et dans son emballage d'origine lorsque cela est possible. Les frais de retour sont à la charge du client, sauf en cas d'article défectueux ou non conforme.</p>
                    </div>
                    <div class="desc">
                        <h3>Exceptions</h3>
                        <p>Conformément à l'article L.221-28 du Code de la consommation, le droit de rétractation ne s'applique pas aux biens descellés après livraison qui ne peuvent être renvoyés pour des raisons d'hygiène ou de protection de la santé, ni aux biens confectionnés selon les spécifications du client. Le <strong>bois de chauffage</strong> livré en vrac ou en filets ouverts ne peut donc pas être retourné une fois la livraison réceptionnée ; nous vous invitons à vérifier votre commande dès sa réception.</p>
                    </div>
                    <div class="desc">
                        <h3>Comment retourner un article ?</h3>
                        <p>Contactez-nous via notre <a href="{{ route('contact.index') }}">formulaire de contact</a> en précisant votre numéro de commande. Nous vous indiquerons la marche à suivre.</p>
                    </div>
                    <div class="desc">
                        <h3>Remboursement</h3>
                        <p>Le remboursement est effectué par virement bancaire, sous 14 jours à compter de la réception de l'article retourné, sur le même moyen ayant servi au règlement initial.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
