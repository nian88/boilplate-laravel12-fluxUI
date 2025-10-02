{{-- resources/views/auth/login.blade.php --}}
@php($title = 'Masuk')
<x-layouts.guest>
    <div class="grid lg:grid-cols-2 min-h-screen">
        {{-- HERO kiri (sembunyikan di mobile) --}}
        <div class="hidden lg:flex relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-400/20 via-fuchsia-400/20 to-teal-300/20 dark:from-sky-400/10 dark:via-fuchsia-400/10 dark:to-teal-300/10"></div>
            <div class="m-auto px-10">
                <img src="{{ asset('logo-light-imap.webp') }}" class="h-10 dark:hidden" alt="logo">
                <img src="{{ asset('logo-light-imap.webp') }}" class="h-10 hidden dark:block" alt="logo">
                <h1 class="mt-10 text-3xl font-semibold text-zinc-900 dark:text-zinc-100">Selamat datang 👋</h1>
                <p class="mt-3 text-zinc-600 dark:text-zinc-300 leading-relaxed">
                    Silakan masuk untuk mengakses Sistem Informasi.
                    UI responsif, nyaman di mobile & desktop.
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

                {{-- Alert status / error --}}
                @if (session('status'))
                    <flux:callout icon="information-circle" class="mb-4">
                        <flux:callout.heading>{{ session('status') }}</flux:callout.heading>
                    </flux:callout>
                @endif

                @if ($errors->any())
                    <flux:callout icon="exclamation-triangle" class="mb-4">
                        <flux:callout.heading>Terjadi kesalahan</flux:callout.heading>
                        <flux:callout.text>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </flux:callout.text>
                    </flux:callout>
                @endif

                <h2 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">Masuk</h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Gunakan email dan kata sandi akun Anda.</p>

                <form class="mt-6 space-y-4" method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <flux:input
                            type="email"
                            label="Email"
                            placeholder="nama@kampus.ac.id"
                            icon="envelope"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                    />

                    {{-- Password + toggle --}}
                    <div x-data="{ show: false }" class="relative">
                        <flux:input
                                type="password"
                                x-bind:type="show ? 'text' : 'password'"
                                label="Kata Sandi"
                                icon="lock-closed"
                                name="password"
                                autocomplete="current-password"
                                required
                                class="pr-10"
                        />
                        <button type="button"
                                class="absolute right-3 mt-[-2.3rem] text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-200"
                                x-on:click="show = !show" aria-label="Toggle password">
                            <!-- ikon eye / eye-off -->
                            <span x-show="!show">👁️</span>
                            <span x-show="show">🙈</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 text-sm">
                            <input type="checkbox" name="remember" class="size-4 rounded border-zinc-300 dark:border-zinc-600">
                            Ingat saya
                        </label>
                        <a href="/" class="text-sm text-sky-600 hover:underline">Lupa kata sandi?</a>
                    </div>

                    <flux:button type="submit" variant="primary" class="w-full" icon="arrow-right-end-on-rectangle">
                        Masuk
                    </flux:button>
                </form>

                {{-- Pemisah / opsi lainnya --}}
                <div class="mt-6 flex items-center gap-4">
                    <flux:separator class="flex-1" variant="subtle" />
                    <span class="text-xs text-zinc-500">atau</span>
                    <flux:separator class="flex-1" variant="subtle" />
                </div>

                {{-- Contoh tombol SSO (opsional; arahkan ke route socialite mu) --}}
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="#"
                       class="inline-flex items-center justify-center gap-2 rounded-lg border px-3 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <img src="/icons/google.svg" class="h-5 w-5" alt="google">
                        <span>Google</span>
                    </a>
                    <a href="#"
                       class="inline-flex items-center justify-center gap-2 rounded-lg border px-3 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <img src="/icons/microsoft.svg" class="h-5 w-5" alt="microsoft">
                        <span>Microsoft</span>
                    </a>
                </div>

                <p class="mt-8 text-center text-sm text-zinc-600 dark:text-zinc-400">
                    Belum punya akun? <a href="/" class="text-sky-600 hover:underline">Daftar</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.guest>