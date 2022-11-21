<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use App\Services\ScoreEngineService;

class BlacklistSave extends ModalComponent
{
    public ?array $record = null;
    public ?int $blacklistId = null;
    public ?string $type = null;
    public ?string $value = null;
    public ?string $reason = null;
    public ?bool $active = null;

    public function mount(?array $record = null, string $forcedType = null): void
    {
        $this->record = $record;
        if ($forcedType) {
            $this->type = $forcedType;
        }
        if ($record) {
            $this->blacklistId = $record['id'];
            $this->type = $record['type'];
            $this->value = $record['value'];
            $this->reason = $record['reason'];
            $this->active = $record['active'];
        }
    }

    public function render()
    {
        return view('livewire.modals.blacklist-save');
    }

    public function cancel(): void
    {
        $this->closeModal();
    }

    public function submit(): void
    {
        $scoreEngineService = new ScoreEngineService();
        $blacklistRecord = $scoreEngineService->updateBlacklistRecord($this->blacklistId, $this->type, $this->value, $this->reason, $this->active ?? false);
        $this->emit('blacklistUpdated', $blacklistRecord);
        $this->closeModal();
    }
}
