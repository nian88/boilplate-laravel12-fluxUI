<?php

namespace App\Livewire\Settings;

use App\Models\User;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserAccess extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $selectedUserId = null;

    public array $selectedRoles = [];
    public array $selectedPermissions = [];

    public function updatingSearch() { $this->resetPage(); }

    public function pick(string $userId): void
    {
        $u = User::findOrFail($userId);
        $this->selectedUserId = $u->id;
        $this->selectedRoles = $u->roles()->pluck('name')->all();
        $this->selectedPermissions = $u->permissions()->pluck('name')->all();
    }

    public function save(): void
    {
        $u = User::findOrFail($this->selectedUserId);
        $u->syncRoles($this->selectedRoles);
        $u->syncPermissions($this->selectedPermissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        session()->flash('ok','Akses user diperbarui.');
    }

    public function getUsersProperty()
    {
        return User::query()
            ->when($this->search, fn($q) =>
            $q->where('name','like',"%{$this->search}%")
                ->orWhere('email','like',"%{$this->search}%")
            )
            ->orderBy('name')
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.settings.user-access', [
            'users' => $this->users,
            'allRoles' => Role::orderBy('name')->pluck('name')->all(),
            'allPermissions' => Permission::orderBy('name')->pluck('name')->all(),
            'title' => 'Akses Pengguna',
            'subtitle' => 'Atur role dan permission per user',
        ])->layout('layouts.app');
    }
}