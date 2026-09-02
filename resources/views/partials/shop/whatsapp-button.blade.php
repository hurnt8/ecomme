@if ($settings->whatsapp_number)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}"
       target="_blank"
       rel="noopener"
       aria-label="Contactez-nous sur WhatsApp"
       style="position:fixed;right:20px;bottom:20px;width:52px;height:52px;border-radius:50%;background:#25D366;
              display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,.25);z-index:1000;">
        <i class="icon-phone" style="color:#fff;font-size:22px;"></i>
    </a>
@endif
