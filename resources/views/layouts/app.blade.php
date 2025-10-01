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
        <flux:sidebar.brand href="#" logo="{{ asset('logo-light-imap.webp') }}"
                            logo:dark="{{ asset('logo-light-imap.webp') }}" name="{{ $title ?? config('app.name') }}"/>
        <flux:sidebar.collapse class="lg:hidden"/>
    </flux:sidebar.header>
    <flux:callout icon="clock">
        <flux:callout.heading id="realtime-clock">Memuat waktu…</flux:callout.heading>
    </flux:callout>
    <flux:separator />
    <flux:sidebar.nav>
        <flux:sidebar.item icon="home" :current="request()->routeIs('dashboard')"  href="{{ route('dashboard') }}">Home</flux:sidebar.item>
        <flux:sidebar.group icon="cog-6-tooth" heading="Pengaturan" expandable  :expanded="request()->routeIs(['settings.*','roles.*','units.*'])">
            <flux:sidebar.item href="{{ route('settings.roles') }}" icon="shield-check" :current="request()->routeIs('settings.roles')">Roles</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('settings.permissions') }}" icon="key" :current="request()->routeIs('settings.permissions')">Permissions</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('settings.user-access') }}" icon="user-group" :current="request()->routeIs('settings.user-access')">User Access</flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>
    <flux:sidebar.spacer/>
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