<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class IndexTable extends Component
{
    use WithPagination;

    public int $pageLength = 10;
    public string $search = '';
    public string $orderBy = 'surname';
    public bool $sortAsc = false;
    public bool $hideNoSalary = false;

    public array $filters = ['all' => 'Vše', 'name' => 'Jméno', 'surname' => 'Příjmení', 'email' => 'E-mail'];
    public string $filter = 'all';

    protected $queryString = ['filter', 'search', 'orderBy', 'sortAsc'];

    protected $listeners = [
        'refreshList' => '$refresh'
    ];

    public function render()
    {
        $users = User::select('users.*',)
            ->when($this->search !== '', function (Builder $query) {
                $query->when($this->filter === 'all', function(Builder $searchQuery) {
                    $searchQuery->where('users.name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('surname', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $this->search . '%');
                });
                $query->when($this->filter === 'name', function(Builder $searchQuery) {
                    $searchQuery->where('users.name', 'LIKE', '%' . $this->search . '%');
                })->when($this->filter === 'surname', function(Builder $searchQuery) {
                    $searchQuery->where('surname', 'LIKE', '%' . $this->search . '%');
                })->when($this->filter === 'email', function(Builder $searchQuery) {
                    $searchQuery->where('email', 'LIKE', '%' . $this->search . '%');
                });
            })->when($this->orderBy !== '', function (Builder $orderQuery) {
                $orderQuery->orderBy($this->orderBy, $this->sortAsc ? 'asc' : 'desc');
            })->simplePaginate($this->pageLength);
        return view('livewire.admin.users.index-table', compact('users'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function orderBy($field): void
    {
        if ($field === $this->orderBy) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->orderBy = $field;
    }
}
