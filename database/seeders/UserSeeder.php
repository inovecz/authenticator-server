<?php
declare(strict_types=1);
namespace Database\Seeders;

use App\Models\User;
use App\Enums\GenderEnum;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Výchozí',
            'surname' => 'Uživatel',
            'email' => 'vychozi.uzivatel@inove.cz',
            'gender' => GenderEnum::MALE,
        ]);
        User::factory()->create([
            'name' => 'Oldřich',
            'surname' => 'Brabec',
            'email' => 'oldrich.brabec@inove.cz',
            'gender' => GenderEnum::MALE,
        ]);
        User::factory(1000)->create();
    }
}
