(function () {
    'use strict';

    function initWhatsAppWidget() {
        const launcher = document.getElementById('waLauncher');
        const panel = document.getElementById('waWindow');
        const header = document.getElementById('waHeader');
        if (!launcher || !panel || panel.dataset.ready === '1') return;
        panel.dataset.ready = '1';

        const minimize = document.getElementById('waMinimize');
        const maximize = document.getElementById('waMaximize');
        const close = document.getElementById('waClose');

        function hidePanel() {
            panel.classList.remove('wa-visible', 'wa-expanded');
            panel.classList.add('wa-minimized');
            panel.setAttribute('aria-hidden', 'true');
            launcher.setAttribute('aria-expanded', 'false');
            try { localStorage.setItem('distan-wa-open', '0'); } catch (e) {}
        }

        // El botón principal abre/cierra mediante el respaldo inline del componente.
        if (minimize) minimize.addEventListener('click', hidePanel);
        if (close) close.addEventListener('click', hidePanel);

        if (maximize) {
            maximize.addEventListener('click', function () {
                panel.classList.toggle('wa-expanded');
                const expanded = panel.classList.contains('wa-expanded');
                maximize.title = expanded ? 'Restaurar tamaño' : 'Ampliar';
                maximize.setAttribute('aria-label', maximize.title);
            });
        }

        // Arrastrar la ventana desde la cabecera, sin interferir con sus controles.
        if (header) {
            let dragging = false;
            let startX = 0, startY = 0, startRight = 0, startBottom = 0;

            header.addEventListener('pointerdown', function (event) {
                if (event.target.closest('button, a')) return;
                const rect = panel.getBoundingClientRect();
                dragging = true;
                startX = event.clientX;
                startY = event.clientY;
                startRight = window.innerWidth - rect.right;
                startBottom = window.innerHeight - rect.bottom;
                panel.classList.add('wa-dragging');
                header.setPointerCapture(event.pointerId);
            });

            header.addEventListener('pointermove', function (event) {
                if (!dragging) return;
                const right = Math.max(8, Math.min(window.innerWidth - panel.offsetWidth - 8, startRight - (event.clientX - startX)));
                const bottom = Math.max(8, Math.min(window.innerHeight - 100, startBottom - (event.clientY - startY)));
                panel.style.right = right + 'px';
                panel.style.bottom = bottom + 'px';
                panel.style.left = 'auto';
                panel.style.top = 'auto';
            });

            function stopDragging() {
                dragging = false;
                panel.classList.remove('wa-dragging');
            }
            header.addEventListener('pointerup', stopDragging);
            header.addEventListener('pointercancel', stopDragging);
        }

        try {
            if (localStorage.getItem('distan-wa-open') === '1') {
                panel.classList.add('wa-visible');
                panel.classList.remove('wa-minimized');
                panel.setAttribute('aria-hidden', 'false');
                launcher.setAttribute('aria-expanded', 'true');
            }
        } catch (e) {}
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWhatsAppWidget);
    } else {
        initWhatsAppWidget();
    }
})();
