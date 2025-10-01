<?php

namespace App\Livewire\Tables;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\{Exportable, Header, Footer};
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Spatie\Permission\Models\Role;

final class UserTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'user-table-njbnyj-table';
    public string $primaryKey = 'users.id'; // ganti ke 'users.uuid' jika nama kolomnya uuid
    public string $sortField  = 'users.created_at';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()->showSearchInput()->showToggleColumns(),
            PowerGrid::exportable(fileName: 'users-export')   // export (butuh openspout + trait)
            ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::footer()->showPerPage()->showRecordCount(), // footer
        ];
    }

    public function datasource(): Builder
    {
        return User::query()->with('roles');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id') // UUID/string aman
            ->add('name')
            ->add('email')
            ->add('roles_names', fn (User $u) => e($u->roles->pluck('name')->join(', ')))
            ->add('created_at')
            ->add('created_at_formatted', fn (User $u) => Carbon::parse($u->created_at)->format('d/m/Y H:i'));

    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->hidden(), // tetap ada untuk PK, disembunyikan
            Column::make('Nama', 'name')->searchable()->sortable(),
            Column::make('Email', 'email')->searchable()->sortable(),
            Column::make('Roles', 'roles_names')->searchable()
                ->visibleInExport(true), // ikut di export
            Column::make('Dibuat', 'created_at_formatted', 'created_at')->sortable(),

            Column::action('Aksi'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder('Cari nama…'),
            Filter::inputText('email')->placeholder('Cari email…'),

            // Filter SELECT by Role (bisa multiSelect juga—tanpa TomSelect pakai select biasa)

            Filter::inputText('roles_names')
                ->placeholder('Cari Role…')
                ->filterRelation('roles', 'name'),
        ];
    }

    /** Pencarian relasi untuk filter by relationship (roles) */
    public function relationSearch(): array
    {
        // supaya filter bisa query ke relasi 'roles' kolom 'name'
        return [
            'roles' => ['name'],
        ];
    }


    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(User $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->class('px-2 py-1 rounded bg-zinc-800 text-white dark:bg-zinc-200 dark:text-zinc-900')
//                ->route('users.edit', ['user' => 'id'])
            ,

            Button::add('delete')
                ->slot('Hapus')
                ->class('px-2 py-1 rounded bg-red-600 text-white')
                ->dispatch('deleteUser', ['id' => 'id'])
                ->confirm('Hapus user ini?'),
        ];
    }

    /** Tangkap event hapus (contoh sederhana) */
    public function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'deleteUser' => 'deleteUser',
        ]);
    }

    public function deleteUser($payload): void
    {
        if (! auth()->user()?->can('users.delete')) return;
        User::query()->whereKey($payload['id'])->delete();
        $this->fillData(); // refresh grid
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}