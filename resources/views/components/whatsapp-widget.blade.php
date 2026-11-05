<div id="distanWhatsApp" class="wa-widget" aria-live="polite">
    <button type="button" id="waLauncher" class="wa-launcher" aria-label="Abrir WhatsApp" title="Abrir WhatsApp" aria-controls="waWindow" aria-expanded="false" onclick="window.distanToggleWhatsApp && window.distanToggleWhatsApp()">
        <svg viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M16.02 3C8.86 3 3.03 8.82 3.03 15.98c0 2.29.6 4.53 1.74 6.51L3 29l6.68-1.75a13 13 0 0 0 6.33 1.62h.01C23.17 28.87 29 23.05 29 15.89A12.9 12.9 0 0 0 16.02 3Zm0 23.66h-.01a10.8 10.8 0 0 1-5.5-1.51l-.4-.24-3.96 1.04 1.06-3.86-.26-.4a10.7 10.7 0 0 1-1.65-5.71c0-5.91 4.81-10.72 10.73-10.72 2.86 0 5.55 1.12 7.57 3.14a10.65 10.65 0 0 1 3.13 7.58c0 5.91-4.81 10.72-10.71 10.72Zm5.88-8.03c-.32-.16-1.9-.94-2.2-1.05-.3-.1-.51-.16-.72.16-.21.32-.83 1.05-1.02 1.26-.19.21-.38.24-.7.08-.32-.16-1.35-.5-2.57-1.58-.95-.85-1.59-1.9-1.78-2.22-.19-.32-.02-.49.14-.65.14-.14.32-.38.48-.57.16-.19.21-.32.32-.53.1-.21.05-.4-.03-.56-.08-.16-.72-1.74-.99-2.38-.26-.62-.52-.54-.72-.55h-.61c-.21 0-.56.08-.85.4-.29.32-1.11 1.08-1.11 2.64s1.14 3.06 1.3 3.27c.16.21 2.24 3.42 5.43 4.8.76.33 1.35.52 1.81.66.76.24 1.45.21 2 .13.61-.09 1.9-.78 2.17-1.53.27-.75.27-1.4.19-1.53-.08-.13-.29-.21-.61-.37Z"/></svg>
    </button>
    <section id="waWindow" class="wa-window" role="dialog" aria-label="WhatsApp Web" aria-hidden="true">
        <header id="waHeader" class="wa-header">
            <div class="wa-brand"><span class="wa-brand-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M16.02 3C8.86 3 3.03 8.82 3.03 15.98c0 2.29.6 4.53 1.74 6.51L3 29l6.68-1.75a13 13 0 0 0 6.33 1.62h.01C23.17 28.87 29 23.05 29 15.89A12.9 12.9 0 0 0 16.02 3Z"/></svg></span><span class="wa-brand-copy"><strong>WhatsApp</strong><small>Acceso desde DISTAN</small></span></div>
            <div class="wa-controls">
                <a class="wa-control" href="https://web.whatsapp.com/" target="_blank" rel="noopener noreferrer" title="Abrir WhatsApp Web en otra pestaña" aria-label="Abrir en otra pestaña"><svg viewBox="0 0 24 24"><path d="M14 3h7v7M21 3l-9 9"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg></a>
                <button type="button" class="wa-control" id="waMinimize" title="Minimizar" aria-label="Minimizar"><svg viewBox="0 0 24 24"><path d="M5 12h14"/></svg></button>
                <button type="button" class="wa-control" id="waMaximize" title="Ampliar" aria-label="Ampliar"><svg viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="1"/></svg></button>
                <button type="button" class="wa-control wa-close" id="waClose" title="Cerrar panel" aria-label="Cerrar"><svg viewBox="0 0 24 24"><path d="m6 6 12 12M18 6 6 18"/></svg></button>
            </div>
        </header>
        <div class="wa-phone-top"><span class="wa-phone-camera"></span><span class="wa-phone-speaker"></span></div>
        <div class="wa-content">
            <iframe id="waFrame" src="https://web.whatsapp.com/" title="WhatsApp Web" allow="clipboard-read; clipboard-write" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
        <div class="wa-phone-bottom"><span></span></div>
    </section>
</div>
<script>
    // Fallback inmediato: permite abrir/cerrar el panel aunque el JS externo tarde o falle.
    window.distanToggleWhatsApp = function () {
        var panel = document.getElementById('waWindow');
        var launcher = document.getElementById('waLauncher');
        if (!panel || !launcher) return;
        var shouldOpen = !panel.classList.contains('wa-visible');
        panel.classList.toggle('wa-visible', shouldOpen);
        panel.classList.toggle('wa-minimized', !shouldOpen);
        panel.setAttribute('aria-hidden', shouldOpen ? 'false' : 'true');
        launcher.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
        try { localStorage.setItem('distan-wa-open', shouldOpen ? '1' : '0'); } catch (e) {}
    };
</script>
<link rel="stylesheet" href="{{ asset('css/whatsapp-widget.css') }}?v=2">
<script src="{{ asset('js/whatsapp-widget.js') }}?v=2" defer></script>
