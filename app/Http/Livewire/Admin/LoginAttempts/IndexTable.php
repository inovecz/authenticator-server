<?php

namespace App\Http\Livewire\Admin\LoginAttempts;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ScoreEngineService;

class IndexTable extends Component
{
    use WithPagination;

    public int $pageLength = 10;
    public string $search = '';
    public string $orderBy = 'id';
    public bool $sortAsc = false;
    public array $filters = ['all' => 'Vše', 'ip' => 'IP adresa', 'device' => 'Zařízení', 'os' => 'Operační systém', 'browser' => 'Prohlížeč', 'user_agent' => 'User agent', 'entity' => 'Entita (hash)'];
    public string $filter = 'all';

    protected array $data = [];

    protected $queryString = ['page', 'filter', 'search', 'orderBy', 'sortAsc'];

    public function orderBy($field): void
    {
        if ($field === $this->orderBy) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->orderBy = $field;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPageLength(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->fetchRemoteData();
        $entities = array_unique(array_map(fn($item) => $item['entity'], $this->data['data'] ?? []));
        $users = User::whereIn('hash', $entities)->get();
        return view('livewire.admin.login-attempts.index-table', ['data' => $this->data, 'users' => $users]);
    }

    private function fetchRemoteData(): void
    {
        $scoreEngineService = new ScoreEngineService();
        $this->data = $scoreEngineService->fetchLoginAttemptDatatable($this->pageLength, $this->page, $this->filter, $this->search, $this->orderBy, $this->sortAsc);
    }
}
