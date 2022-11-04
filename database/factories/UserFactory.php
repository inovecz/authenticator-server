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
        $username = $name . $surname;
        return [
            'name' => $name,
            'surname' => $surname,
            // 'gender' => $gender,
            'email' => Str::of($username)->lower()->ascii() . '@' . $this->faker->safeEmailDomain(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
