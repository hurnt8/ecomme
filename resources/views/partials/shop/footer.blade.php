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
            {{-- Three unlabelled columns of 12px links squeezed to a third of a phone screen was
                 unreadable, and giving each its full width instead would make an already long
                 footer far longer. Headed groups that collapse below the sidebar breakpoint: one
                 tap to open the one you want, nothing to scroll past if you don't. --}}
            @foreach ([
                ['title' => 'La maison', 'links' => [
                    ['À propos', url('/a-propos')],
                    ['Aide / FAQ', url('/aide')],
                    ['Contact', url('/contact')],
                    ['CGV', url('/cgv')],
                    ['Carrières', url('/carrieres')],
                    ['Presse', url('/presse')],
                ]],
                ['title' => 'Boutique', 'links' => [
                    ['Toute la boutique', route('catalog')],
                    ['Confidentialité', url('/confidentialite')],
                    ['Cookies', url('/cookies')],
                    ['Mentions légales', url('/mentions-legales')],
                    ['Accessibilité', url('/accessibilite')],
                ]],
                ['title' => 'Commande & aide', 'links' => [
                    ['Livraison', url('/livraison')],
                    ['Retours', url('/retours')],
                    ['Moyens de paiement', url('/moyens-paiement')],
                    ['Suivi de commande', route('tracking.index')],
                    ['Blog', url('/blog')],
                    [auth()->check() ? 'Mon compte' : 'Connexion', auth()->check() ? route('account.index') : route('login')],
                ]],
            ] as $group)
                <div class="col-md-2 col-sm-4 col-md-push-1 fh5co-footer-group" x-data="{ open: false }">
                    <h4 class="fh5co-footer-heading" @click="open = !open" role="button" :aria-expanded="open ? 'true' : 'false'">
                        {{ $group['title'] }}
                        <i class="icon-arrow-down" :class="{ 'is-open': open }" aria-hidden="true"></i>
                    </h4>
                    <ul class="fh5co-footer-links" :class="{ 'is-open': open }">
                        @foreach ($group['links'] as [$label, $href])
                            <li><a href="{{ $href }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="row copyright">
            <div class="col-md-12 text-center">
                <p>
                    <small class="block">&copy; {{ now()->year }} {{ $settings->site_name }}. Tous droits réservés.</small>
                </p>
            </div>
        </div>
    </div>
</footer>
