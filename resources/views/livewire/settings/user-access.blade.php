<div class="max-w-6xl mx-auto p-6 space-y-6">
    @if (session('ok'))
        <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-2 text-green-800">
            {{ session('ok') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom kiri: daftar user --}}
        <div class="lg:col-span-1">
            <div class="flex items-center gap-3 mb-3">
                <flux:input icon="magnifying-glass" placeholder="Cari user (nama/email)..."
                            wire:model.live="search" class="flex-1" />
            </div>
            <div class="rounded-xl border divide-y max-h-[70vh] overflow-auto">
                @forelse($users as $u)
                    <button class="w-full text-left p-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 {{ $selectedUserId===$u->id ? 'bg-zinc-50 dark:bg-zinc-800' : '' }}"
                            wire:click="pick('{{ $u->id }}')">
                        <div class="font-medium">{{ $u->name }}</div>
                        <div class="text-xs text-zinc-500">{{ $u->email }}</div>
                        <div class="mt-1 flex flex-wrap gap-1">
                            @foreach($u->roles()->pluck('name') as $rn)
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-zinc-100 dark:bg-zinc-900">{{ $rn }}</span>
                            @endforeach
                        </div>
                    </button>
                @empty
                    <div class="p-4 text-zinc-500">Tidak ada user.</div>
                @endforelse
            </div>
            <div class="mt-3">{{ $users->links() }}</div>
        </div>

        {{-- Kolom kanan: editor akses --}}
        <div class="lg:col-span-2">
            @if($selectedUserId)
                <flux:heading size="lg" class="mb-2">Akses untuk User</flux:heading>
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <flux:heading size="md">Roles</flux:heading>
                        <div class="mt-3 grid grid-cols-1 gap-2 max-h-[46vh] overflow-auto pr-2">
                            @foreach($allRoles as $role)
                                <label class="flex items-center gap-3 p-2 rounded border hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                    <input type="checkbox" class="size-4"
                                           value="{{ $role }}" wire:model="selectedRoles">
                                    <span class="text-sm">{{ $role }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <flux:heading size="md">Permissions (langsung ke user)</flux:heading>
                        <div class="mt-3 grid grid-cols-1 gap-2 max-h-[46vh] overflow-auto pr-2">
                            @foreach($allPermissions as $perm)
                                <label class="flex items-center gap-3 p-2 rounded border hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                    <input type="checkbox" class="size-4"
                                           value="{{ $perm }}" wire:model="selectedPermissions">
                                    <span class="text-sm">{{ $perm }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex">
                    <flux:spacer />
                    <flux:button variant="primary" icon="check" wire:click="save">Simpan Perubahan</flux:button>
                </div>
            @else
                <flux:callout icon="user">
                    <flux:callout.heading>Pilih user di panel kiri</flux:callout.heading>
                    <flux:callout.text>Gunakan kotak pencarian untuk menemukan user, kemudian atur role & permission di sini.</flux:callout.text>
                </flux:callout>
            @endif
        </div>
    </div>
</div>