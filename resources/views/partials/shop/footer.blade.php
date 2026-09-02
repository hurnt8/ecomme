<div id="fh5co-started">
    <div class="container">
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                <h2>Newsletter</h2>
                <p>Recevez nos nouveautés et nos offres en avant-première.</p>
            </div>
        </div>
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-inline" action="{{ url('/newsletter') }}" method="POST">
                    @csrf
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Votre e-mail" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <button type="submit" class="btn btn-default btn-block">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<footer id="fh5co-footer" role="contentinfo">
    <div class="container">
        <div class="row row-pb-md">
            <div class="col-md-4 fh5co-widget">
                <h3>{{ $settings->site_name }}</h3>
                <p>{{ $settings->tagline }}</p>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                <ul class="fh5co-footer-links">
                    <li><a href="{{ url('/a-propos') }}">À propos</a></li>
                    <li><a href="{{ url('/aide') }}">Aide / FAQ</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="{{ url('/cgv') }}">CGV</a></li>
                    <li><a href="{{ url('/carrieres') }}">Carrières</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                <ul class="fh5co-footer-links">
                    <li><a href="{{ url('/boutique') }}">Boutique</a></li>
                    <li><a href="{{ url('/confidentialite') }}">Confidentialité</a></li>
                    <li><a href="{{ url('/cookies') }}">Cookies</a></li>
                    <li><a href="{{ url('/mentions-legales') }}">Mentions légales</a></li>
                    <li><a href="{{ url('/accessibilite') }}">Accessibilité</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                <ul class="fh5co-footer-links">
                    <li><a href="{{ url('/livraison') }}">Livraison</a></li>
                    <li><a href="{{ url('/retours') }}">Retours</a></li>
                    <li><a href="{{ url('/moyens-paiement') }}">Moyens de paiement</a></li>
                    <li><a href="{{ url('/suivi') }}">Suivi de commande</a></li>
                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                </ul>
            </div>
        </div>

        <div class="row copyright">
            <div class="col-md-12 text-center">
                <p>
                    <small class="block">&copy; {{ now()->year }} {{ $settings->site_name }}. Tous droits réservés.</small>
                    @if ($settings->contact_email)
                        <small class="block">{{ $settings->contact_address }} — <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a></small>
                    @endif
                </p>
                <p>
                    <ul class="fh5co-social-icons">
                        @if ($settings->social_facebook)
                            <li><a href="{{ $settings->social_facebook }}" target="_blank" rel="noopener"><i class="icon-facebook"></i></a></li>
                        @endif
                        @if ($settings->social_instagram)
                            <li><a href="{{ $settings->social_instagram }}" target="_blank" rel="noopener"><i class="icon-instagram"></i></a></li>
                        @endif
                        @if ($settings->social_twitter)
                            <li><a href="{{ $settings->social_twitter }}" target="_blank" rel="noopener"><i class="icon-twitter"></i></a></li>
                        @endif
                    </ul>
                </p>
            </div>
        </div>
    </div>
</footer>
