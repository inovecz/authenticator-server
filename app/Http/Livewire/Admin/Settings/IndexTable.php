<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Services\ScoreEngineService;

class IndexTable extends Component
{
    public array $settings = [
        [
            'title' => 'Přihlášení',
            'subtitle' => 'Podmínky, za kterých nebude uživateli umožněno se přihlásit. Pokud je některá podmínka vypnuta, je přítomnost na blacklistu hodnocena dle nastavení kontroly identity.',
            'items' => [
                [
                    'title' => 'Blokovat přihlášení zakázaným e-mailem',
                    'subtitle' => 'Pokud je e-mail v blacklistu e-mailů',
                    'setting' => 'deny_login.blacklist.email',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Blokovat přihlášení e-mailem se zakázené domény',
                    'subtitle' => 'Pokud je doména e-mailu v blacklistu domén',
                    'setting' => 'deny_login.blacklist.domain',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Blokovat přihlášení ze zakázané IP adresy',
                    'subtitle' => 'Pokud je IP adresa klienta v blacklistu IP adres',
                    'setting' => 'deny_login.blacklist.ip',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Blokovat přihlášení ze zakázaných operačních systémů (Systémy určené pro provádění penetračních testů, hacking)',
                    'subtitle' => 'Pokud je v user-agentu klienta detekován některý z následujících operačních systémů: Kali, Parrot, BlackArch, BackBox, Samurai, Pentoo, DEFT, Caine, Network Security Toolkit, BugTraq',
                    'setting' => 'deny_login.blacklist.os',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Práh vyžádání dvoufaktoru',
                    'subtitle' => 'Pokud hodnota skóre překročí danou mez (včetně), je požadováno ověření pomocí kódu',
                    'setting' => 'scoring.twofactor_when_score_gte',
                    'type' => 'integer',
                    'range' => [0, 100],
                ],
                [
                    'title' => 'Práh blokace přihlášení',
                    'subtitle' => 'Pokud hodnota skóre překročí danou mez (včetně), je přihlášení zablokováno',
                    'setting' => 'scoring.disallow_when_score_gte',
                    'type' => 'integer',
                    'range' => [0, 100],
                ],
            ],
        ],
        [
            'title' => 'Kontrola hesel',
            'subtitle' => 'Přihlašovací hesla jsou hodnocena následujícími pravidly:',
            'items' => [
                [
                    'title' => 'Uniklá hesla',
                    'subtitle' => 'Kontrolovat heslo na výskyt v databázi úniků <a href="https://haveibeenpwned.com" class="link" target="_blank">haveibeewnpwned.com</a>',
                    'setting' => 'scoring.password.leaks',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Délka',
                    'subtitle' => 'Kontrolovat délku hesla',
                    'setting' => 'scoring.password.length',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Znaky - čísla',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje čísla 0-9',
                    'setting' => 'scoring.password.complexity.numbers',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Znaky - písmena',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje písmena a-ž, A-Ž',
                    'setting' => 'scoring.password.complexity.letters',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Znaky - malá a velká písmena',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje malá i velká písmena',
                    'setting' => 'scoring.password.complexity.mixed_case',
                    'type' => 'bool',
                ], [
                    'title' => 'Znaky - symboly',
                    'subtitle' => 'Kontrolovat zda heslo obsahuje symboly, např. !?#$&…',
                    'setting' => 'scoring.password.complexity.symbols',
                    'type' => 'bool',
                ],
            ],
        ],
        [
            'title' => 'Kontrola identity',
            'subtitle' => 'Přihlašující se uživatel je hodnocen následujícími pravidly:',
            'items' => [
                [
                    'title' => 'Uniklé e-maily',
                    'subtitle' => 'Kontrolovat e-mail proti databázi uniklých e-mailů',
                    'setting' => 'scoring.entity.leaks.email',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Uniklá telefonní čísla',
                    'subtitle' => 'Kontrolovat telefonní číslo proti databázi uniklých telefonních čísel',
                    'setting' => 'scoring.entity.leaks.phone',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Dočasné e-maily',
                    'subtitle' => 'Kontrolovat e-mail proti databázi dočasných e-mailových domén',
                    'setting' => 'scoring.entity.disposable_email',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Chování uživatele',
                    'subtitle' => 'Kontrolovat přihlášení na základě strojového učení',
                    'setting' => 'scoring.entity.behavior',
                    'type' => 'bool',
                ],
                [
                    'title' => 'Blacklist',
                    'subtitle' => 'Kontrola na výskyt v blacklistu (pokud není přihlášení automaticky odmítnuto)',
                    'setting' => 'scoring.entity.blacklist',
                    'type' => 'bool',
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
