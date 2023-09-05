<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Menu extends Component
{
    public array $menuItems = [
        'top' => [
            'guest' => [
                [
                    'name' => 'Přihlášení',
                    'icon' => 'fa-solid fa-lock',
                    'link' => 'admin.loginPage',
                    'activeRoute' => 'admin',
                ],
            ],
            'admin' => [
                [
                    'name' => 'Nástěnka',
                    'icon' => 'fa-solid fa-house',
                    'link' => 'dashboard',
                    'activeRoute' => 'admin/dashboard',
                ], [
                    'name' => 'Uživatelé',
                    'icon' => 'fa-solid fa-users',
                    'link' => 'users-list',
                    'activeRoute' => 'admin/users',
                ], [
                    'name' => 'Blacklisty',
                    'icon' => 'fa-solid fa-ban',
                    'link' => 'blacklists',
                    'activeRoute' => 'admin/blacklists',
                ], [
                    'name' => 'Pokusy o přihlášení',
                    'icon' => 'fa-solid fa-user-lock',
                    'link' => 'loginAttempts',
                    'activeRoute' => 'admin/login-attempts',
                ],
            ],
        ],
        'bottom' => [
            'admin' => [
                [
                    'name' => 'Nastavení',
                    'icon' => 'fa-solid fa-cog',
                    'link' => 'settings',
                    'activeRoute' => 'admin/settings',
                ],
            ],
            'guest' => [],
        ],
    ];

    public function render()
    {
        return view('livewire.admin.menu');
    }
}
