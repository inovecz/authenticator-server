<?php
declare(strict_types=1);
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Petr',
            'surname' => 'Kateřiňák',
            'email' => 'katerinak@indeev.eu'
        ]);
        User::factory(999)->create();
    }
}
