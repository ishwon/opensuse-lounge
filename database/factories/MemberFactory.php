<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Enums\MemberStatus;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email_target' => fake()->safeEmail(),
            'email_nick' => fake()->optional()->userName(),
            'email_full' => fake()->optional()->email(),
            'libera_nick' => fake()->optional()->userName(),
            'libera_cloak' => $this->faker->optional()->domainWord().'.users.libera.chat',
            'libera_cloak_applied' => fake()->optional()->iso8601(),
            'status' => fake()->randomElement(MemberStatus::cases()),
        ];
    }

    /**
     * Indicate that the member is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => MemberStatus::ACTIVE,
        ]);
    }

    /**
     * Indicate that the member is emeritus.
     */
    public function emeritus(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => MemberStatus::EMERITUS,
        ]);
    }
}
