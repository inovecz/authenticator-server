<?php

namespace App\Http\Livewire\Admin\Blacklists;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ScoreEngineService;
use Illuminate\Pagination\Paginator;

class IndexTable extends Component
{
    use WithPagination;

    public int $pageLength = 10;
    public string $search = '';
    public string $orderBy = 'id';
    public bool $sortAsc = false;
    public array $filters = ['all' => 'Vše', 'value' => 'Hodnota', 'reason' => 'Důvod'];
    public string $filter = 'all';

    protected string $blacklistType = 'DOMAIN';
    protected array $data = [];

    protected $queryString = ['page', 'filter', 'search', 'orderBy', 'sortAsc'];

    public function mount(string $blacklistType)
    {
        $this->blacklistType = $blacklistType;
    }

    public function render()
    {
        $this->fetchRemoteData();
        return view('livewire.admin.blacklists.index-table', ['data' => $this->data]);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPageLength(): void
    {
        $this->resetPage();
    }

    private function fetchRemoteData(): void
    {
        $scoreEngineService = new ScoreEngineService();
        $this->data = $scoreEngineService->fetchBlacklistDatatable($this->blacklistType, $this->pageLength, $this->page, $this->filter, $this->search, $this->orderBy, $this->sortAsc);
    }
}
