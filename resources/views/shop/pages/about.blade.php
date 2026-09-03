@extends('layouts.shop')

@section('title', 'À propos')
@section('meta_description', 'L\'histoire et le savoir-faire de ' . $settings->site_name . ', mobilier et décoration en matières durables.')

@section('content')
    <x-shop.page-hero title="À propos" :subtitle="$settings->site_name" image="img_bg_1.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="about-content">
                <div class="row animate-box">
                    <div class="col-md-6">
                        <div class="desc">
                            <h3>Notre histoire</h3>
                            <p>{{ $settings->site_name }} est né d'un constat simple : le mobilier vendu en grande diffusion vieillit mal, tandis que les pièces artisanales restent souvent hors de portée. Nous avons choisi de travailler directement avec des ateliers de fabrication en bois massif, béton fibré et matières nobles, pour proposer un mobilier durable à un prix honnête.</p>
                            <p>Chaque pièce de notre catalogue est sélectionnée pour sa robustesse autant que pour son design : nous préférons une gamme resserrée de meubles bien conçus à un catalogue démesuré.</p>
                        </div>
                        <div class="desc">
                            <h3>Notre engagement</h3>
                            <p>Nous privilégions les matières massives et les finitions naturelles (huile, cire) plutôt que les placages et vernis synthétiques, pour un mobilier qui se répare et se rénove au lieu de se jeter.</p>
                            <p>{{ $settings->description }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img class="img-responsive" src="{{ asset('template/images/img_bg_1.jpg') }}" alt="Atelier">
                    </div>
                </div>
                <div class="row animate-box">
                    <div class="col-md-12">
                        <div class="desc">
                            <h3>Notre gamme</h3>
                            <p>Notre catalogue s'organise en cinq univers complémentaires : <strong>Mobilier</strong> pour l'intérieur (assises, tables, rangements), <strong>Jardin &amp; Extérieur</strong> pour aménager terrasses et jardins, <strong>Décoration</strong> pour personnaliser chaque pièce, <strong>Équipement Maison</strong> pour l'électroménager et le quotidien, et <strong>Bois &amp; Chauffage</strong> pour le chauffage au bois, une activité historique de la maison que nous poursuivons en parallèle du mobilier.</p>
                        </div>
                    </div>
                </div>
                <div class="row animate-box">
                    <div class="col-md-4">
                        <div class="desc text-center">
                            <h3>+10 ans</h3>
                            <p>d'expérience dans la sélection de mobilier et de bois de qualité</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="desc text-center">
                            <h3>5 univers</h3>
                            <p>Mobilier, Jardin &amp; Extérieur, Décoration, Équipement Maison, Bois &amp; Chauffage</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="desc text-center">
                            <h3>France</h3>
                            <p>expédition en zone euro, préparation et service client basés en France</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
