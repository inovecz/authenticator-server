<?php
declare(strict_types=1);
namespace Database\Seeders;

use App\Models\Admin;
use App\Enums\GenderEnum;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Petr',
            'surname' => 'Kateřiňák',
            'gender' => GenderEnum::MALE,
            'email' => 'katerinak@indeev.eu',
            'password' => \Hash::make('123456789'),
        ]);
    }
}
