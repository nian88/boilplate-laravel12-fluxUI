<!doctype html>
<html lang="id">
<head>
    @fluxAppearance
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>{{ $title ?? config('app.name') }}</title>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
{{-- SIDEBAR --}}
<flux:sidebar sticky collapsible="mobile"
              class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.header>
        <flux:sidebar.brand href="#" logo="logo-light-imap.webp"
                            logo:dark="logo-light-imap.webp" name="{{ $title ?? config('app.name') }}"/>
        <flux:sidebar.collapse class="lg:hidden"/>
    </flux:sidebar.header>
    <flux:callout icon="clock">
        <flux:callout.heading id="realtime-clock">Memuat waktu…</flux:callout.heading>
    </flux:callout>
    <flux:separator />
    <flux:sidebar.nav>
        <flux:sidebar.item icon="home" href="#" current>Home</flux:sidebar.item>
        <flux:sidebar.item icon="inbox" badge="12" href="#">Inbox</flux:sidebar.item>
        <flux:sidebar.item icon="document-text" href="#">Documents</flux:sidebar.item>
        <flux:sidebar.item icon="calendar" href="#">Calendar</flux:sidebar.item>
        <flux:sidebar.group expandable heading="Favorites" class="grid">
            <flux:sidebar.item href="#">Marketing site</flux:sidebar.item>
            <flux:sidebar.item href="#">Android app</flux:sidebar.item>
            <flux:sidebar.item href="#">Brand guidelines</flux:sidebar.item>
        </flux:sidebar.group>
        <flux:sidebar.group icon="folder" heading="Master" expandable>
            <flux:sidebar.item href="{{ route('users.index') }}" icon="user-group"
                               :current="request()->routeIs('users.*')">Pengguna
            </flux:sidebar.item>
            <flux:sidebar.item href="{{ route('roles.index') }}" icon="shield-check"
                               :current="request()->routeIs('roles.*')">Role & Permission
            </flux:sidebar.item>
            <flux:sidebar.item href="{{ route('units.index') }}" icon="building-office"
                               :current="request()->routeIs('units.*')">Unit
            </flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>
    <flux:sidebar.spacer/>
    <flux:sidebar.nav>
        <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
        <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
    </flux:sidebar.nav>
    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:sidebar.profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin"/>
        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>
            <flux:menu.separator/>
            <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>
<flux:header class="block! bg-white lg:bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:navbar class="lg:hidden w-full">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>
        <flux:spacer/>
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="https://fluxui.dev/img/demo/user.png"/>
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                    <flux:menu.radio>Truly Delta</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator/>
                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:navbar>
    <flux:navbar scrollable>
        <flux:navbar.item href="#" current>Dashboard</flux:navbar.item>
        <flux:navbar.item badge="32" href="#">Orders</flux:navbar.item>
        <flux:navbar.item href="#">Catalog</flux:navbar.item>
        <flux:navbar.item href="#">Configuration</flux:navbar.item>
    </flux:navbar>
</flux:header>
{{-- KONTEN UTAMA --}}
<flux:main container>
    @if(!empty($title))
        <flux:heading size="xl" level="1">{{ $title }}</flux:heading>
        <flux:text class="mt-2 mb-6 text-base">{{ $subtitle ?? '' }}</flux:text>
        <flux:separator variant="subtle"/>
    @endif

    {{-- Slot Livewire / section Blade --}}
    {{ $slot ?? '' }}
    @yield('content')
</flux:main>

@fluxScripts
</body>
</html>