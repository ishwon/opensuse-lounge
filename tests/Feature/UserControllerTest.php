<?php

declare(strict_types=1);

use App\Enums\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

describe('UserController', function () {
    describe('show method', function () {
        test('membership users can view their own profile', function () {
            $user = User::factory()->membership()->create();

            actingAs($user);

            get(route('users.show'))
                ->assertStatus(200)
                ->assertViewIs('users.show')
                ->assertViewHas('user');
        });

        test('election users can view their own profile', function () {
            $user = User::factory()->election()->create();

            actingAs($user);

            get(route('users.show'))
                ->assertStatus(200)
                ->assertViewIs('users.show')
                ->assertViewHas('user');
        });

        test('heroes users cannot access profile', function () {
            $user = User::factory()->create([
                'email_verified_at' => now(),
                'roles' => [UserRole::HEROES->value],
            ]);

            actingAs($user);

            get(route('users.show'))
                ->assertStatus(403);
        });

        test('regular users cannot access profile', function () {
            $user = User::factory()->create([
                'email_verified_at' => now(),
                'roles' => [],
            ]);

            actingAs($user);

            get(route('users.show'))
                ->assertStatus(403);
        });
    });

    describe('edit method', function () {
        test('membership users can access edit form', function () {
            $user = User::factory()->membership()->create();

            actingAs($user);

            get(route('users.edit'))
                ->assertStatus(200)
                ->assertViewIs('users.edit')
                ->assertViewHas('user');
        });

        test('election users can access edit form', function () {
            $user = User::factory()->election()->create();

            actingAs($user);

            get(route('users.edit'))
                ->assertStatus(200)
                ->assertViewIs('users.edit')
                ->assertViewHas('user');
        });

        test('heroes users cannot access edit form', function () {
            $user = User::factory()->create([
                'email_verified_at' => now(),
                'roles' => [UserRole::HEROES->value],
            ]);

            actingAs($user);

            get(route('users.edit'))
                ->assertStatus(403);
        });

        test('regular users cannot access edit form', function () {
            $user = User::factory()->create([
                'email_verified_at' => now(),
                'roles' => [],
            ]);

            actingAs($user);

            get(route('users.edit'))
                ->assertStatus(403);
        });
    });

    describe('update method', function () {
        test('membership users can update their email', function () {
            $user = User::factory()->membership()->create();
            $newEmail = 'newemail@example.com';

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => $newEmail,
                ])
                ->assertRedirect(route('users.show'))
                ->assertSessionHas('success', 'Your profile has been updated successfully!');

            expect($user->fresh()->email)->toBe($newEmail);
        });

        test('election users can update their email', function () {
            $user = User::factory()->election()->create();
            $newEmail = 'election-new@example.com';

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => $newEmail,
                ])
                ->assertRedirect(route('users.show'))
                ->assertSessionHas('success', 'Your profile has been updated successfully!');

            expect($user->fresh()->email)->toBe($newEmail);
        });

        test('allows updating password', function () {
            $user = User::factory()->membership()->create();
            $newPassword = 'newpassword123';

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => $user->email,
                    'password' => $newPassword,
                    'password_confirmation' => $newPassword,
                ])
                ->assertRedirect(route('users.show'))
                ->assertSessionHas('success', 'Your profile has been updated successfully!');

            expect(Hash::check($newPassword, $user->fresh()->password))->toBeTrue();
        });

        test('validates email uniqueness', function () {
            $user = User::factory()->membership()->create();
            $other = User::factory()->election()->create();

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => $other->email,
                ])
                ->assertRedirect()
                ->assertSessionHasErrors('email');
        });

        test('validates email format', function () {
            $user = User::factory()->membership()->create();

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => 'invalid-email',
                ])
                ->assertRedirect()
                ->assertSessionHasErrors('email');
        });

        test('validates password confirmation', function () {
            $user = User::factory()->membership()->create();

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => $user->email,
                    'password' => 'password123',
                    'password_confirmation' => 'differentpassword',
                ])
                ->assertRedirect()
                ->assertSessionHasErrors('password');
        });

        test('denies heroes users from updating profile', function () {
            $user = User::factory()->create([
                'email_verified_at' => now(),
                'roles' => [UserRole::HEROES->value],
            ]);

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => 'newemail@example.com',
                ])
                ->assertStatus(403);
        });

        test('denies regular users from updating profile', function () {
            $user = User::factory()->create([
                'email_verified_at' => now(),
                'roles' => [],
            ]);

            actingAs($user)
                ->put(route('users.update'), [
                    'email' => 'newemail@example.com',
                ])
                ->assertStatus(403);
        });
    });
});
