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

    public array $filters = ['all' => 'Vše', 'name' => 'Jméno', 'surname' => 'Příjmení', 'email' => 'E-mail', 'phone' => 'Telefon', 'hash' => 'Hash'];
    public string $filter = 'all';

    protected $queryString = ['filter', 'search', 'orderBy', 'sortAsc'];

    protected $listeners = [
        'refreshList' => '$refresh',
        'deleteConfirmed' => 'deleteUser',
        'userSaved' => 'userSaved',
    ];

    public function render()
    {
        $users = User::select('users.*',)
            ->when($this->search !== '', function (Builder $query) {
                $query->when($this->filter === 'all', function (Builder $searchQuery) {
                    $searchQuery->where('users.name', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('surname', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('phone', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('hash', 'LIKE', '%'.$this->search.'%');
                });
                $query->when($this->filter === 'name', function (Builder $searchQuery) {
                    $searchQuery->where('users.name', 'LIKE', '%'.$this->search.'%');
                })->when($this->filter === 'surname', function (Builder $searchQuery) {
                    $searchQuery->where('surname', 'LIKE', '%'.$this->search.'%');
                })->when($this->filter === 'email', function (Builder $searchQuery) {
                    $searchQuery->where('email', 'LIKE', '%'.$this->search.'%');
                })->when($this->filter === 'phone', function (Builder $searchQuery) {
                    $searchQuery->where('phone', 'LIKE', '%'.$this->search.'%');
                })->when($this->filter === 'hash', function (Builder $searchQuery) {
                    $searchQuery->where('hash', 'LIKE', '%'.$this->search.'%');
                });
            })->when($this->orderBy !== '', function (Builder $orderQuery) {
                if ($this->orderBy === 'fullname') {
                    $orderQuery->orderBy('surname', $this->sortAsc ? 'asc' : 'desc')
                        ->orderBy('name', $this->sortAsc ? 'asc' : 'desc');
                } else {
                    $orderQuery->orderBy($this->orderBy, $this->sortAsc ? 'asc' : 'desc');
                }
            })->simplePaginate($this->pageLength);
        return view('livewire.admin.users.index-table', compact('users'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPageLength(): void
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

    public function deleteUser(array $passThrough): void
    {
        $hash = $passThrough['hash'] ?? null;
        if (!$hash) {
            return;
        }
        $deleted = User::where('hash', $hash)->delete();
        if ($deleted) {
            $this->render();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Uživatel byl úspěšně smazán', 'options' => ['timeOut' => 1000]]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'danger', 'message' => 'Uživatele nebylo možné smazat', 'options' => ['timeOut' => 5000]]);
        }
    }

    public function userSaved(array|false $user): void
    {
        if ($user !== false) {
            $this->render();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Uživatel byl úspěšně uložen', 'options' => ['timeOut' => 1000]]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'danger', 'message' => 'Uživatele nebylo možné uložit', 'options' => ['timeOut' => 5000]]);
        }
    }
}
