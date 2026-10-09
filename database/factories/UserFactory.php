<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'roles' => [],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user has the membership role.
     */
    public function membership(): static
    {
        return $this->state(fn (array $attributes) => [
            'roles' => [UserRole::MEMBERSHIP->value],
        ]);
    }

    /**
     * Indicate that the user has the election role.
     */
    public function election(): static
    {
        return $this->state(fn (array $attributes) => [
            'roles' => [UserRole::ELECTION->value],
        ]);
    }

    /**
     * Indicate that the user has both membership and election roles.
     */
    public function allRoles(): static
    {
        return $this->state(fn (array $attributes) => [
            'roles' => [UserRole::MEMBERSHIP->value, UserRole::ELECTION->value],
        ]);
    }
}
