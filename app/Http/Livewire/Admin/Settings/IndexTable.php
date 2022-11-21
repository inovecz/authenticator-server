<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Services\ScoreEngineService;

class IndexTable extends Component
{
    public array $settings = [
        [
            'title' => 'Kontrola hesel',
            'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias assumenda hic natus optio?',
            'items' => [
                [
                    'title' => 'Databáze úniků',
                    'subtitle' => 'Kontrolovat heslo na výskyt v databázi úniků <a href="https://haveibeenpwned.com" class="link" target="_blank">haveibeewnpwned.com</a>',
                    'setting' => 'scoringPasswordLeaks',
                ],
                [
                    'title' => 'Délka',
                    'subtitle' => 'Kontrolovat délku hesla',
                    'setting' => 'scoringPasswordLength',
                ],
                [
                    'title' => 'Složitost',
                    'subtitle' => 'Kontrolovat složitost hesla',
                    'setting' => 'scoringPasswordComplexity',
                ],
            ],
        ],
        [
            'title' => 'Kontrola identity',
            'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias assumenda hic natus optio?',
            'items' => [
                [
                    'title' => 'Geodata',
                    'subtitle' => 'Kontrolovat přihlášení z obvyklé lokace',
                    'setting' => 'scoringEntityGeodata',
                ],
                [
                    'title' => 'Zařízení',
                    'subtitle' => 'Kontrolovat přihlášení z obvyklého zařízení',
                    'setting' => 'scoringEntityDevice',
                ],
            ],
        ],
    ];

    public ?bool $scoringPasswordLeaks = null;
    public ?bool $scoringPasswordLength = null;
    public ?bool $scoringPasswordComplexity = null;
    public ?bool $scoringEntityGeodata = null;
    public ?bool $scoringEntityDevice = null;

    public function mount(): void
    {
        $this->fetchSettings();
    }

    public function render()
    {
        return view('livewire.admin.settings.index-table');
    }

    private function fetchSettings(): void
    {
        $scoreEngineService = new ScoreEngineService();
        $settings = $scoreEngineService->fetchSettings();

        if ($settings !== false) {
            $this->scoringPasswordLeaks = $settings['scoring']['password']['leaks'] ?? null;
            $this->scoringPasswordLength = $settings['scoring']['password']['length'] ?? null;
            $this->scoringPasswordComplexity = $settings['scoring']['password']['complexity'] ?? null;
            $this->scoringEntityGeodata = $settings['scoring']['entity']['geodata'] ?? null;
            $this->scoringEntityDevice = $settings['scoring']['entity']['device'] ?? null;
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Nepodařilo se načíst nastavení', 'options' => ['timeOut' => 5000]]);
        }
    }

    public function updateSetting(string $key): void
    {
        $value = $this->$key;
        $key = Str::of($key)->snake()->replace('_', '.')->toString();
        $scoreEngineService = new ScoreEngineService();
        $updated = $scoreEngineService->updateSetting($key, $value);
        if ($updated) {
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Nastavení bylo úspěšně uloženo', 'options' => ['timeOut' => 1000]]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Nastavení se nepoda5ilo uložit', 'options' => ['timeOut' => 5000]]);
        }
    }
}
