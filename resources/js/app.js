import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid' // atau .js
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

function refreshTime() {
    const el = document.getElementById('realtime-clock');
    if (!el) return;

    const zone = 'Asia/Jakarta';
    const d = new Date();

    const datePart = new Intl.DateTimeFormat('id-ID', {
        weekday: 'short', day: '2-digit', month: 'short', year: 'numeric',
        timeZone: zone
    }).format(d).replace(',', '');

    const timePart = new Intl.DateTimeFormat('id-ID', {
        hour: '2-digit', minute: '2-digit', second: '2-digit',
        hour12: false, timeZone: zone
    }).format(d).replace(/\./g, ':');

    el.textContent = `${datePart} \u2013 ${timePart}`;
}

document.addEventListener('DOMContentLoaded', () => {
    refreshTime();
    setInterval(refreshTime, 1000);
});

// Opsional: rapikan perilaku
NProgress.configure({ showSpinner: false, trickleSpeed: 120 })

/** A. Progress untuk initial page load (full reload) */
let __initial = setTimeout(() => NProgress.start(), 120) // hindari flicker utk load yg cepat
window.addEventListener('load', () => { clearTimeout(__initial); NProgress.done() })

/** B. Progress untuk Livewire wire:navigate */
window.addEventListener('livewire:navigating', () => NProgress.start())
window.addEventListener('livewire:navigated',  () => NProgress.done())

/** C. Progress untuk request Livewire (aksi/submit) — Livewire v3 hooks */
document.addEventListener('livewire:init', () => {
    Livewire.hook('commit', ({ succeed, fail }) => {
        NProgress.start()
        succeed(() => queueMicrotask(() => NProgress.done()))
        fail(() => NProgress.done())
    })
})