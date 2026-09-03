{{-- Not shown on the contact page: the same WhatsApp link already appears inline in "Nos
     coordonnées" there, and as a fixed bottom-right element it would otherwise drift over the
     contact form's fields as the (full-width, one-column) page is scrolled. --}}
@if ($settings->whatsapp_number && ! request()->routeIs('contact.index'))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}"
       target="_blank"
       rel="noopener"
       aria-label="Contactez-nous sur WhatsApp"
       class="js-whatsapp-button"
       style="position:fixed;right:20px;bottom:20px;width:52px;height:52px;border-radius:50%;background:#25D366;
              display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,.25);z-index:1000;
              transition:opacity .2s;">
        <i class="icon-phone" style="color:#fff;font-size:22px;"></i>
    </a>
@endif
