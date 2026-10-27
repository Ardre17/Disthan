/* DISTAN PWA: no guarda páginas ni datos privados en caché. */
self.addEventListener('install', (event) => { self.skipWaiting(); });
self.addEventListener('activate', (event) => { event.waitUntil(self.clients.claim()); });
self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') return;
  // Las solicitudes van a la red; no se almacenan datos de sesión ni del ERP.
  event.respondWith(fetch(event.request));
});
