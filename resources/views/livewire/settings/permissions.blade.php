<div class="max-w-5xl mx-auto p-6 space-y-6">
    @if (session('ok'))
        <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-2 text-green-800">
            {{ session('ok') }}
        </div>
    @endif

    <div class="flex items-center gap-3">
        <flux:input icon="magnifying-glass" placeholder="Cari permission..."
                    wire:model.live="search" class="flex-1" />
        <flux:button variant="primary" icon="plus" wire:click="create">Permission Baru</flux:button>
    </div>

    <div class="rounded-xl border divide-y">
        @forelse($rows as $p)
            <div class="p-4 flex items-center gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <h3 class="font-medium">{{ $p->name }}</h3>
                        <flux:badge size="sm">{{ $p->guard_name }}</flux:badge>
                    </div>
                    <p class="text-xs text-zinc-500 mt-1">{{ $p->roles()->count() }} roles · {{ $p->users()->count() }} users</p>
                </div>
                <div class="flex gap-2">
                    <flux:button size="sm" icon="pencil" wire:click="edit({{ $p->id }})">Edit</flux:button>
                    <flux:button size="sm" icon="trash" variant="danger" wire:click="confirmDelete({{ $p->id }})">Hapus</flux:button>
                </div>
            </div>
        @empty
            <div class="p-6 text-zinc-500">Belum ada permission.</div>
        @endforelse
    </div>

    <div>{{ $rows->links() }}</div>

    {{-- Modal Form --}}
    <flux:modal wire:model.self="showFormModal" class="md:w-[28rem]">
        <flux:heading size="lg">{{ $editingId ? 'Edit Permission' : 'Permission Baru' }}</flux:heading>
        <div class="space-y-4 mt-4">
            <flux:input label="Nama Permission" placeholder="mis. tickets.update" wire:model="name" />
            <flux:input label="Guard" placeholder="web" wire:model="guard_name" class="max-w-xs" />
        </div>
        <div class="flex mt-6">
            <flux:spacer />
            <flux:button variant="ghost" x-on:click="$flux.modals().close()">Batal</flux:button>
            <flux:button variant="primary" wire:click="save">Simpan</flux:button>
        </div>
    </flux:modal>

    {{-- Modal Hapus --}}
    <flux:modal wire:model.self="showDeleteModal" class="min-w-[22rem]">
        <flux:heading size="lg">Hapus permission?</flux:heading>
        <div class="flex mt-6">
            <flux:spacer />
            <flux:button variant="ghost" x-on:click="$flux.modals().close()">Batal</flux:button>
            <flux:button variant="danger" wire:click="delete">Hapus</flux:button>
        </div>
    </flux:modal>
</div>