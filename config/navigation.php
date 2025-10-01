<?php
return [
    ['label'=>'Dashboard','icon'=>'home','route'=>'dashboard'],
    ['label'=>'Master','icon'=>'folder','children'=>[
        ['label'=>'Pengguna','icon'=>'user-group','route'=>'users.index'],
        ['label'=>'Role & Permission','icon'=>'shield-check','route'=>'roles.index'],
        ['label'=>'Unit','icon'=>'building-office','route'=>'units.index'],
    ]],
    ['label'=>'Transaksi','icon'=>'clipboard-document-list','children'=>[
        ['label'=>'Tiket','icon'=>'document-text','route'=>'tickets.index'],
        ['label'=>'Laporan','icon'=>'chart-bar','route'=>'reports.index'],
    ]],
];