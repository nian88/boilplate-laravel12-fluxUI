<div class="max-w-5xl mx-auto p-6 space-y-6">
    @if (session('ok'))
        <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-2 text-green-800">
            {{ session('ok') }}
        </div>
    @endif

    <div class="flex items-center gap-3">
        <flux:input icon="magnifying-glass" placeholder="Cari role..."
                    wire:model.live="search" class="flex-1" />
        <flux:button variant="primary" icon="plus" wire:click="create">Role Baru</flux:button>
    </div>

    <div class="rounded-xl border divide-y">
        @forelse ($rows as $r)
            <div class="p-4 flex items-start gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <h3 class="font-semibold text-lg">{{ $r->name }}</h3>
                        <flux:badge size="sm">{{ $r->guard_name }}</flux:badge>
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-300 mt-1">
                        {{ $r->permissions()->count() }} permissions · {{ $r->users()->count() }} users
                    </p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach ($r->permissions()->limit(8)->pluck('name') as $p)
                            <span class="text-xs px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800">{{ $p }}</span>
                        @endforeach
                        @if($r->permissions()->count() > 8)
                            <span class="text-xs text-zinc-500">+{{ $r->permissions()->count() - 8 }} lagi</span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    <flux:button size="sm" icon="key" variant="primary" color="green" wire:click="openPerms({{ $r->id }})">Permissions</flux:button>
                    <flux:button size="sm" icon="pencil" wire:click="edit({{ $r->id }})">Edit</flux:button>
                    <flux:button size="sm" icon="trash" variant="danger" wire:click="confirmDelete({{ $r->id }})">Hapus</flux:button>
                </div>
            </div>
        @empty
            <div class="p-6 text-zinc-500">Belum ada role.</div>
        @endforelse
    </div>

    <div>{{ $rows->links() }}</div>

    {{-- Modal Form Role --}}
    <flux:modal wire:model.self="showFormModal" class="md:w-[28rem]">
        <div class="space-y-6">
            <flux:heading size="lg">{{ $editingId ? 'Edit Role' : 'Role Baru' }}</flux:heading>

            <flux:input label="Nama Role" placeholder="mis. admin"
                        wire:model="name" />
            <flux:input label="Guard" placeholder="web" wire:model="guard_name" class="max-w-xs" />

            <div class="flex">
                <flux:spacer />
                <flux:button variant="ghost" x-on:click="$flux.modals().close()">Batal</flux:button>
                <flux:button variant="primary" wire:click="save">Simpan</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Modal Hapus --}}
    <flux:modal wire:model.self="showDeleteModal" class="min-w-[22rem]">
        <flux:heading size="lg">Hapus role?</flux:heading>
        <flux:text>Semua relasi role ke user/permission akan dilepas.</flux:text>
        <div class="flex mt-6">
            <flux:spacer />
            <flux:button variant="ghost" x-on:click="$flux.modals().close()">Batal</flux:button>
            <flux:button variant="danger" wire:click="delete">Hapus</flux:button>
        </div>
    </flux:modal>

    {{-- Modal Permissions --}}
    <flux:modal wire:model.self="showPermModal" class="md:w-[40rem]">
        <div class="space-y-4">
            <flux:heading size="lg">Atur Permissions untuk Role</flux:heading>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[50vh] overflow-auto pr-2">
                @foreach ($allPermissions as $perm)
                    <label class="flex items-center gap-3 p-2 rounded border hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <input type="checkbox" class="size-4"
                               value="{{ $perm }}" wire:model="selectedPermissions">
                        <span class="text-sm">{{ $perm }}</span>
                    </label>
                @endforeach
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button variant="ghost" x-on:click="$flux.modals().close()">Batal</flux:button>
                <flux:button variant="primary" wire:click="savePerms">Simpan</flux:button>
            </div>
        </div>
    </flux:modal>
</div>