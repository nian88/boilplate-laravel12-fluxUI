<?php

namespace App\Livewire\Settings;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class Permissions extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showFormModal = false;
    public bool $showDeleteModal = false;

    public ?int $editingId = null;
    public string $name = '';
    public string $guard_name = 'web';

    protected function rules(): array
    {
        return [
            'name' => [
                'required','string','max:150',
                Rule::unique(config('permission.table_names.permissions'),'name')
                    ->ignore($this->editingId)
                    ->where(fn($q) => $q->where('guard_name',$this->guard_name)),
            ],
            'guard_name' => ['required','string','max:50'],
        ];
    }

    public function updatingSearch(){ $this->resetPage(); }

    public function create(): void
    {
        $this->reset(['editingId','name']);
        $this->guard_name = 'web';
        $this->showFormModal = true;
    }

    public function edit(int $id): void
    {
        $p = Permission::findOrFail($id);
        $this->editingId = $p->id;
        $this->name = $p->name;
        $this->guard_name = $p->guard_name;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->editingId) {
            Permission::findOrFail($this->editingId)->update($data);
        } else {
            Permission::create($data);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->showFormModal = false;
        session()->flash('ok','Permission disimpan.');
        $this->reset(['editingId','name']);
    }

    public function confirmDelete(int $id): void
    {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $perm = Permission::findOrFail($this->editingId);
        $perm->roles()->detach();
        $perm->users()->detach();
        $perm->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->showDeleteModal = false;
        $this->reset(['editingId']);
        session()->flash('ok','Permission dihapus.');
    }

    public function getRowsProperty()
    {
        return Permission::query()
            ->when($this->search, fn($q) => $q->where('name','like',"%{$this->search}%"))
            ->orderBy('name')
            ->paginate(12);
    }

    public function render(): View
    {
        return view('livewire.settings.permissions', [
            'rows' => $this->rows,
            'title' => 'Pengaturan Permission',
            'subtitle' => 'Kelola daftar permission',
        ])->layout('layouts.app');
    }
}