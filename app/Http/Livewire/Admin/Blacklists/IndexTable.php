<?php

namespace App\Http\Livewire\Admin\Blacklists;

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
    public array $filters = ['all' => 'Vše', 'value' => 'Hodnota', 'reason' => 'Důvod'];
    public string $filter = 'all';

    public string $blacklistType = 'DOMAIN';
    protected array $blacklistTypes = ['DOMAIN', 'EMAIL', 'IP'];
    protected array $data = [];

    protected $queryString = ['page', 'filter', 'search', 'orderBy', 'sortAsc'];

    protected $listeners = [
        'refreshList' => '$refresh',
        'blacklistUpdated' => 'blacklistUpdated',
        'deleteConfirmed' => 'deleteBlacklistRecord'
    ];

    public function mount(string $blacklistType = 'DOMAIN'): void
    {
        $this->blacklistType = $blacklistType;
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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPageLength(): void
    {
        $this->resetPage();
    }

    public function changeType(string $type): void
    {
        $this->blacklistType = !in_array($type, $this->blacklistTypes, true) ? 'DOMAIN' : $type;
        $this->render();
    }

    public function render()
    {
        $this->fetchRemoteData();
        return view('livewire.admin.blacklists.index-table', ['data' => $this->data]);
    }

    private function fetchRemoteData(): void
    {
        $scoreEngineService = new ScoreEngineService();
        $this->data = $scoreEngineService->fetchBlacklistDatatable($this->blacklistType, $this->pageLength, $this->page, $this->filter, $this->search, $this->orderBy, $this->sortAsc);
    }

    public function toggleBlacklistRecordActive(int $blacklistRecordId): void
    {
        $scoreEngineService = new ScoreEngineService();
        $updatedRecord = $scoreEngineService->toggleBlacklistRecordActive($blacklistRecordId);
        $this->data = array_map(static fn(array $record) => $record['id'] === $blacklistRecordId ? $record['active'] = $updatedRecord['active'] : null, $this->data);
        $this->render();
    }

    public function deleteBlacklistRecord(array $passThrough): void
    {
        $blacklistRecordId = $passThrough['recordId'] ?? null;
        if (!$blacklistRecordId) {
            return;
        }
        $scoreEngineService = new ScoreEngineService();
        $scoreEngineService->deleteBlacklistRecord($blacklistRecordId);
        $this->fetchRemoteData();
        $this->render();
    }

    public function blacklistUpdated(array $blacklist): void
    {
        $this->data = array_map(static fn(array $record) => $record['id'] === $blacklist['id'] ? $blacklist : $record, $this->data);
        $this->render();
    }
}
