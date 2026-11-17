{{-- Incluir una sola vez antes de </body> en layouts/app.blade.php --}}
<div id="distanLoading" class="distan-loading" aria-hidden="true">
    <div class="distan-loading-card">
        <div class="distan-loading-mark">D</div>
        <div class="distan-loading-name">DISTAN <span>ERP</span></div>
        <div class="distan-loading-caption">Preparando tu espacio de trabajo</div>
        <div class="distan-loading-track"><i></i></div>
    </div>
</div>
<style>
.distan-loading{position:fixed;inset:0;z-index:99999;background:#f4f7fb;display:flex;align-items:center;justify-content:center;transition:opacity .25s ease,visibility .25s ease}.distan-loading.is-hidden{opacity:0;visibility:hidden;pointer-events:none}.distan-loading-card{text-align:center;padding:30px}.distan-loading-mark{width:58px;height:58px;margin:0 auto 12px;border-radius:17px;background:#14243b;color:#fff;font-size:37px;font-weight:900;display:grid;place-items:center;box-shadow:0 10px 28px #14243b30}.distan-loading-name{font-size:19px;font-weight:900;letter-spacing:1px;color:#14243b}.distan-loading-name span{color:#2581d8}.distan-loading-caption{font-size:11px;color:#718096;margin-top:6px}.distan-loading-track{width:155px;height:4px;border-radius:10px;background:#dbe5f0;margin:18px auto 0;overflow:hidden}.distan-loading-track i{display:block;width:40%;height:100%;background:#2581d8;border-radius:10px;animation:distanLoad 1.1s ease-in-out infinite}@keyframes distanLoad{0%{transform:translateX(-110%)}100%{transform:translateX(390%)}}
</style>
<script>
(function(){var el=document.getElementById('distanLoading');if(!el)return;function hide(){el.classList.add('is-hidden');setTimeout(function(){el.remove()},350)}if(document.readyState==='complete'){hide()}else{window.addEventListener('load',hide,{once:true});setTimeout(hide,8000)}})();
</script>
