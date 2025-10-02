<div class="grid lg:grid-cols-2 min-h-screen">
    {{-- HERO kiri (visible ≥ lg) --}}
    <div class="hidden lg:flex relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-400/20 via-fuchsia-400/20 to-teal-300/20 dark:from-sky-400/10 dark:via-fuchsia-400/10 dark:to-teal-300/10"></div>
        <div class="m-auto px-10">
            <img src="/logo-light.png" class="h-10 dark:hidden" alt="logo">
            <img src="/logo-dark.png" class="h-10 hidden dark:block" alt="logo">
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
                <img src="/logo-light.png" class="h-10 inline dark:hidden" alt="logo">
                <img src="/logo-dark.png" class="h-10 hidden dark:inline" alt="logo">
            </div>

            @if (session('status'))
                <flux:callout icon="information-circle" class="mb-4">
                    <flux:callout.heading>{{ session('status') }}</flux:callout.heading>
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

                {{-- Password + toggle (pakai Alpine yang aman untuk Flux input) --}}
                <div x-data="{ show: false }"
                     x-init="
       const el = document.getElementById('pwd');
       const apply = () => { if (el) el.type = show ? 'text' : 'password' };
       apply(); $watch('show', apply);
     "
                     class="space-y-1">

                    {{-- wrapper relative agar tombol diposisikan terhadap tinggi input --}}
                    <div class="relative">
                        <flux:input
                                id="pwd"
                                type="password"
                                label="Kata Sandi"
                                placeholder="••••••••"
                                icon="lock-closed"
                                wire:model.live="password"
                                autocomplete="current-password"
                                required
                                class="pr-12"  {{-- beri ruang untuk tombol di kanan --}}
                        />

                        {{-- tombol eye, selalu center terhadap input --}}
                        <button type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 grid place-items-center
                   text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-200"
                                x-on:click="show = !show"
                                aria-label="Toggle password">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="1.7" d="M2 12s3.8-7 10-7 10 7 10 7-3.8 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="1.7" d="M3 3l18 18M10.6 10.7a3 3 0 004.7 3.3M7.5 7.7C5.2 9.1 3.7 11 3 12c0 0 3.8 7 10 7 2 0 3.7-.6 5.1-1.4M13.5 6.2C12.9 6.1 12.5 6 12 6 5.8 6 2 13 2 13"/>
                            </svg>
                        </button>
                    </div>
                </div>


                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm">

                    </label>
                    <a href="#" class="text-sm text-sky-600 hover:underline" wire:navigate>
                        Lupa kata sandi?
                    </a>
                </div>

                <flux:button type="submit" variant="primary" class="w-full"
                             icon="arrow-right-end-on-rectangle"
                             wire:loading.attr="disabled">
                    <span wire:loading.remove>Masuk</span>
                    <span wire:loading>Memproses…</span>
                </flux:button>
            </form>

        </div>
    </div>
</div>