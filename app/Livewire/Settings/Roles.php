<?php

namespace App\Livewire\Settings;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class Roles extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showFormModal = false;
    public bool $showDeleteModal = false;
    public bool $showPermModal = false;

    public ?int $editingId = null;
    public string $name = '';
    public string $guard_name = 'web';

    /** Permissions picker */
    public array $selectedPermissions = [];

    protected function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:150',
                Rule::unique(config('permission.table_names.roles'), 'name')
                    ->ignore($this->editingId)
                    ->where(fn ($q) => $q->where('guard_name', $this->guard_name)),
            ],
            'guard_name' => ['required','string','max:50'],
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    public function create(): void
    {
        $this->reset(['editingId','name','guard_name']);
        $this->guard_name = 'web';
        $this->showFormModal = true;
    }

    public function edit(int $id): void
    {
        $r = Role::findOrFail($id);
        $this->editingId = $r->id;
        $this->name = $r->name;
        $this->guard_name = $r->guard_name;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->editingId) {
            $role = Role::findOrFail($this->editingId);
            $role->update($data);
        } else {
            $role = Role::create($data);
            $this->editingId = $role->id;
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->showFormModal = false;
        session()->flash('ok', 'Role disimpan.');
        $this->reset(['editingId','name','guard_name']);
    }

    public function confirmDelete(int $id): void
    {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $role = Role::findOrFail($this->editingId);
        // detach relasi agar aman
        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->showDeleteModal = false;
        $this->reset(['editingId']);
        session()->flash('ok','Role dihapus.');
    }

    public function openPerms(int $id): void
    {
        $role = Role::findOrFail($id);
        $this->editingId = $role->id;
        $this->selectedPermissions = $role->permissions()->pluck('name')->all();
        $this->showPermModal = true;
    }

    public function savePerms(): void
    {
        $role = Role::findOrFail($this->editingId);
        $role->syncPermissions($this->selectedPermissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->showPermModal = false;
        session()->flash('ok','Permission untuk role diperbarui.');
    }

    public function getRowsProperty()
    {
        return Role::query()
            ->when($this->search, fn($q) => $q->where('name','like',"%{$this->search}%"))
            ->orderBy('name')
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.settings.roles', [
            'rows' => $this->rows,
            'allPermissions' => Permission::orderBy('name')->pluck('name')->all(),
            'title' => 'Pengaturan Role',
            'subtitle' => 'Kelola role dan permission per role',
        ])->layout('layouts.app');
    }
}