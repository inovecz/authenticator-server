<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    public function definition(): array
    {
        $genders = GenderEnum::cases();
        $gender = $genders[array_rand($genders)];
        $genderName = $gender === GenderEnum::OTHER ? fake()->randomElement([GenderEnum::MALE, GenderEnum::FEMALE]) : $gender;
        $name = $genderName === GenderEnum::MALE ? fake()->firstNameMale() : fake()->firstNameFemale();
        $surname = $genderName === GenderEnum::MALE ? fake()->lastNameMale() : fake()->lastNameFemale();
        return [
            'name' => $name,
            'surname' => $surname,
            'gender' => $gender->value,
            'email' => fake()->unique()->email,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'last_attemp_at' => fake()->dateTimeBetween(now()->subMonths(12), now()),
            'login_count' => $loginCount = fake()->numberBetween(0, 10),
            'average_score' => $loginCount === 0 ? 0 : fake()->randomFloat(2, 0, 100),
        ];
    }
}
