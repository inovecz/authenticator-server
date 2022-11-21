<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
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
                    'setting' => 'scoring.password.leaks',
                ],
                [
                    'title' => 'Délka',
                    'subtitle' => 'Kontrolovat délku hesla',
                    'setting' => 'scoring.password.length',
                ],
                [
                    'title' => 'Znaky - čísla',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje čísla 0-9',
                    'setting' => 'scoring.password.complexity.numbers',
                ],
                [
                    'title' => 'Znaky - písmena',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje písmena a-ž, A-Ž',
                    'setting' => 'scoring.password.complexity.letters',
                ],
                [
                    'title' => 'Znaky - malá a velká písmena',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje malá i velká písmena',
                    'setting' => 'scoring.password.complexity.mixed_case',
                ], [
                    'title' => 'Znaky - symboly',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje symboly, např. !?#$&…',
                    'setting' => 'scoring.password.complexity.symbols',
                ],
            ],
        ],
        [
            'title' => 'Kontrola identity',
            'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias assumenda hic natus optio?',
            'items' => [
                [
                    'title' => 'Uniklé e-maily',
                    'subtitle' => 'Kontrolovat e-mail proti databázi uniklých e-mailů',
                    'setting' => 'scoring.entity.leaks.email',
                ],
                [
                    'title' => 'Uniklá telefonní čísla',
                    'subtitle' => 'Kontrolovat telefonní číslo proti databázi uniklých telefonních čísel',
                    'setting' => 'scoring.entity.leaks.phone',
                ],
                [
                    'title' => 'Dočasné e-maily',
                    'subtitle' => 'Kontrolovat e-mail proti databázi dočasných e-mailových domén',
                    'setting' => 'scoring.entity.disposable_email',
                ],
                [
                    'title' => 'Geodata',
                    'subtitle' => 'Kontrolovat přihlášení z obvyklé lokace',
                    'setting' => 'scoring.entity.geodata',
                ],
                [
                    'title' => 'Zařízení',
                    'subtitle' => 'Kontrolovat přihlášení z obvyklého zařízení',
                    'setting' => 'scoring.entity.device',
                ],
            ],
        ],
    ];

    public function mount(): void
    {
        foreach ($this->settings as $group) {
            foreach ($group['items'] as $setting) {
                $this->fill([dot_to_varname($setting['setting']) => false]);
            }
        }
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
            foreach ($this->settings as $indexG => $group) {
                foreach ($group['items'] as $indexS => $setting) {
                    $varName = dot_to_varname($setting['setting']);
                    $settingItem = $settings;
                    $exploded = explode('.', $setting['setting']);
                    collect($exploded)->each(function ($key) use (&$settingItem, $indexG, $indexS) {
                        $settingItem = $settingItem[$key] ?? false;
                    });
                    $this->{$varName} = $settingItem;
                }
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Nepodařilo se načíst nastavení', 'options' => ['timeOut' => 5000]]);
        }
    }

    public function updateSetting(string $key): void
    {
        $value = $this->$key;
        $key = varname_to_dot($key);
        $scoreEngineService = new ScoreEngineService();
        $updated = $scoreEngineService->updateSetting($key, $value);
        if ($updated) {
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Nastavení bylo úspěšně uloženo', 'options' => ['timeOut' => 1000]]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Nastavení se nepoda5ilo uložit', 'options' => ['timeOut' => 5000]]);
        }
    }
}
