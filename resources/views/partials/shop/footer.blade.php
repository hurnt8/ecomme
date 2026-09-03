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
                <form class="form-inline" action="{{ route('newsletter.store') }}" method="POST">
                    @csrf
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="newsletter-email" class="sr-only">Email</label>
                            <input type="email" name="email" class="form-control" id="newsletter-email" placeholder="Votre e-mail" required>
                            @error('email')
                                <span style="display:block;color:#ffdada;font-size:12px;margin-top:4px;">{{ $message }}</span>
                            @enderror
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
                <div class="fh5co-contact-info">
                    <ul>
                        @if ($settings->contact_phone)
                            <li class="phone"><a href="tel:{{ $settings->contact_phone }}">{{ $settings->contact_phone }}</a></li>
                        @endif
                        @if ($settings->contact_email)
                            <li class="email"><a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a></li>
                        @endif
                        @if ($settings->contact_address)
                            <li class="address">{{ $settings->contact_address }}</li>
                        @endif
                        @if ($settings->whatsapp_number)
                            <li class="url"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}" target="_blank" rel="noopener">WhatsApp</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-4 col-md-push-1">
                <ul class="fh5co-footer-links">
                    <li><a href="{{ url('/a-propos') }}">À propos</a></li>
                    <li><a href="{{ url('/aide') }}">Aide / FAQ</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="{{ url('/cgv') }}">CGV</a></li>
                    <li><a href="{{ url('/carrieres') }}">Carrières</a></li>
                    <li><a href="{{ url('/presse') }}">Presse</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-4 col-md-push-1">
                <ul class="fh5co-footer-links">
                    <li><a href="{{ route('catalog') }}">Boutique</a></li>
                    <li><a href="{{ url('/confidentialite') }}">Confidentialité</a></li>
                    <li><a href="{{ url('/cookies') }}">Cookies</a></li>
                    <li><a href="{{ url('/mentions-legales') }}">Mentions légales</a></li>
                    <li><a href="{{ url('/accessibilite') }}">Accessibilité</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-4 col-md-push-1">
                <ul class="fh5co-footer-links">
                    <li><a href="{{ url('/livraison') }}">Livraison</a></li>
                    <li><a href="{{ url('/retours') }}">Retours</a></li>
                    <li><a href="{{ url('/moyens-paiement') }}">Moyens de paiement</a></li>
                    <li><a href="{{ route('tracking.index') }}">Suivi de commande</a></li>
                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                    <li><a href="{{ auth()->check() ? route('account.index') : route('login') }}">{{ auth()->check() ? 'Mon compte' : 'Connexion' }}</a></li>
                </ul>
            </div>
        </div>

        <div class="row copyright">
            <div class="col-md-12 text-center">
                <p>
                    <small class="block">&copy; {{ now()->year }} {{ $settings->site_name }}. Tous droits réservés.</small>
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
