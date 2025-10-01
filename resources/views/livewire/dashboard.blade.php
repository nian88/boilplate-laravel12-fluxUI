<div class="max-w-3xl mx-auto p-6 space-y-6">
    {{-- Flash sederhana (tanpa Flux Pro) --}}
    @if (session('ok'))
        <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-2 text-green-800">
            {{ session('ok') }}
        </div>
    @endif

    <div class="flex gap-3 items-center">
        <flux:input icon="magnifying-glass"
                    placeholder="Cari tugas..."
                    wire:model.live="search"
                    class="flex-1" />

        <flux:button variant="primary" icon="plus" wire:click="create">
            Tugas Baru
        </flux:button>
    </div>

    {{-- Daftar (tanpa Table Pro): list sederhana --}}
    <div class="divide-y divide-zinc-200 dark:divide-zinc-800 border rounded-xl">
        @forelse ($rows as $task)
            <div class="p-4 flex items-start gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <h3 class="font-semibold text-lg">{{ $task->title }}</h3>
                        @php
                            $color = match($task->status) {
                                'todo' => 'zinc',
                                'doing' => 'blue',
                                'done' => 'green',
                                default => 'zinc'
                            };
                        @endphp
                        <flux:badge size="sm" :color="$color" inset="top bottom">
                            {{ strtoupper($task->status) }}
                        </flux:badge>
                    </div>
                    @if($task->description)
                        <p class="text-sm text-zinc-600 dark:text-zinc-300 mt-1">
                            {{ $task->description }}
                        </p>
                    @endif
                    @if($task->due_date)
                        <p class="text-xs text-zinc-500 mt-1">
                            Jatuh tempo: {{ \Illuminate\Support\Carbon::parse($task->due_date)->isoFormat('DD MMM YYYY') }}
                        </p>
                    @endif
                </div>

                <div class="flex gap-2">
                    <flux:button size="sm" variant="ghost" icon="pencil" wire:click="edit({{ $task->id }})" />
                    <flux:button size="sm" variant="danger" icon="trash"
                                 wire:click="confirmDelete({{ $task->id }})" />
                </div>
            </div>
        @empty
            <div class="p-6 text-zinc-500">Belum ada data.</div>
        @endforelse
    </div>

    {{-- Pagination standar --}}


    {{-- Modal Form (pakai binding wire:model.self seperti saran doks Flux) --}}
    <flux:modal wire:model.self="showFormModal" class="md:w-[32rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    as
                </flux:heading>
                <flux:text class="mt-2">Isi data tugas lalu simpan.</flux:text>
            </div>

            <flux:input label="Judul" placeholder="Mis. Perbaiki bug notifikasi"
                        wire:model="title" />

            <flux:textarea label="Deskripsi" rows="3"
                           wire:model="description" />

            <flux:select label="Status" wire:model="status" class="max-w-xs">
                <flux:select.option value="todo">To-Do</flux:select.option>
                <flux:select.option value="doing">Doing</flux:select.option>
                <flux:select.option value="done">Done</flux:select.option>
            </flux:select>

            <flux:input type="date" max="2999-12-31" label="Jatuh Tempo"
                        wire:model="due_date" class="max-w-xs" />

            <div class="flex">
                <flux:spacer />
                <flux:button variant="ghost" x-on:click="$flux.modals().close()">Batal</flux:button>
                <flux:button variant="primary" wire:click="save">Simpan</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Modal konfirmasi hapus --}}
    <flux:modal wire:model.self="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Hapus tugas?</flux:heading>
            <flux:text>Tindakan ini tidak bisa dibatalkan.</flux:text>
            <div class="flex">
                <flux:spacer />
                <flux:button variant="ghost" x-on:click="$flux.modals().close()">Batal</flux:button>
                <flux:button variant="danger" wire:click="delete">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
</div>