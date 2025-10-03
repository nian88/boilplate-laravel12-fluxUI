<div class="grid lg:grid-cols-2 min-h-screen">
    {{-- HERO kiri (visible ≥ lg) --}}
    <div class="hidden lg:flex relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-400/20 via-fuchsia-400/20 to-teal-300/20 dark:from-sky-400/10 dark:via-fuchsia-400/10 dark:to-teal-300/10"></div>
        <div class="m-auto px-10">
            <img src="{{ asset('logo-light-imap.webp') }}" class="h-10 dark:hidden" alt="logo">
            <img src="{{ asset('logo-light-imap.webp') }}" class="h-10 hidden dark:block" alt="logo">
            <h1 class="mt-10 text-3xl font-semibold text-zinc-900 dark:text-zinc-100">Selamat datang 👋</h1>
            <p class="mt-3 text-zinc-600 dark:text-zinc-300 leading-relaxed">
                Silakan masuk untuk mengakses Sistem Informasi.
            </p>
            <div class="mt-8 grid gap-3 max-w-md">
                <div class="h-24 rounded-2xl backdrop-blur bg-white/40 dark:bg-zinc-800/40 border border-white/50 dark:border-zinc-700/60 shadow-sm"></div>
                <div class="h-24 rounded-2xl backdrop-blur bg-white/40 dark:bg-zinc-800/40 border border-white/50 dark:border-zinc-700/60 shadow-sm"></div>
            </div>
        </div>
    </div>

    {{-- FORM kanan --}}
    <div class="flex items-center justify-center p-6 lg:p-10">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center lg:hidden">
                <img src="{{ asset('logo-light-imap.webp') }}" class="h-10 inline dark:hidden" alt="logo">
                <img src="{{ asset('logo-light-imap.webp') }}" class="h-10 hidden dark:inline" alt="logo">
            </div>

            @php
                $status  = session('status');
                $type    = is_array($status) ? ($status['type'] ?? 'info') : 'info';
                $message = is_array($status) ? ($status['message'] ?? '') : $status;
                $icon    = $type === 'success' ? 'check-circle' : ($type === 'error' ? 'exclamation-triangle' : 'information-circle');
            @endphp

            @if ($message)
                <flux:callout :variant="$type" icon="{{ $icon }}" class="mb-4">
                    <flux:callout.heading>{{ $message }}</flux:callout.heading>
                </flux:callout>
            @endif

            <h2 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">Masuk</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Gunakan email dan kata sandi akun Anda.</p>

            <form class="mt-6 space-y-4" wire:submit="login">
                {{-- Email --}}
                <div>
                    <flux:input
                            type="email"
                            label="Email"
                            placeholder="nama@kampus.ac.id"
                            icon="envelope"
                            wire:model.live.debounce.500ms="email"
                            autocomplete="username"
                            required
                    />
                </div>
                <flux:input id="pwd"
                            type="password"
                            label="Kata Sandi"
                            placeholder="••••••••"
                            icon="lock-closed"
                            wire:model.live="password"
                            autocomplete="current-password"
                            required
                            viewable />

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm">

                    </label>
                    <a href="#" class="text-sm text-sky-600 hover:underline" wire:navigate>
                        Lupa kata sandi?
                    </a>
                </div>

                <flux:button
                        :disabled="$errors->has('email') || $errors->has('password') || blank($email) || blank($password)"
                        type="submit" variant="primary" class="w-full"
                        icon="arrow-right-end-on-rectangle"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Masuk</span>
                    <span wire:loading>Memproses…</span>
                </flux:button>
            </form>

        </div>
    </div>
</div>