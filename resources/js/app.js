import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid' // atau .js

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