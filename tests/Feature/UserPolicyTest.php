<?php

declare(strict_types=1);

use App\Enums\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

describe('UserPolicy', function () {
    describe('view ability', function () {
        test('allows membership user to view their own profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::MEMBERSHIP->value],
            ]);

            expect(Gate::forUser($user)->allows('view', $user))->toBeTrue();
        });

        test('allows election user to view their own profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::ELECTION->value],
            ]);

            expect(Gate::forUser($user)->allows('view', $user))->toBeTrue();
        });

        test('denies membership user from viewing another user profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::MEMBERSHIP->value],
            ]);
            $otherUser = User::factory()->create([
                'roles' => [UserRole::MEMBERSHIP->value],
            ]);

            expect(Gate::forUser($user)->denies('view', $otherUser))->toBeTrue();
        });

        test('denies heroes user from viewing their own profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::HEROES->value],
            ]);

            expect(Gate::forUser($user)->denies('view', $user))->toBeTrue();
        });

        test('denies regular user from viewing their own profile', function () {
            $user = User::factory()->create([
                'roles' => [],
            ]);

            expect(Gate::forUser($user)->denies('view', $user))->toBeTrue();
        });
    });

    describe('update ability', function () {
        test('allows membership user to update their own profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::MEMBERSHIP->value],
            ]);

            expect(Gate::forUser($user)->allows('update', $user))->toBeTrue();
        });

        test('allows election user to update their own profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::ELECTION->value],
            ]);

            expect(Gate::forUser($user)->allows('update', $user))->toBeTrue();
        });

        test('denies membership user from updating another user profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::MEMBERSHIP->value],
            ]);
            $otherUser = User::factory()->create([
                'roles' => [UserRole::MEMBERSHIP->value],
            ]);

            expect(Gate::forUser($user)->denies('update', $otherUser))->toBeTrue();
        });

        test('denies heroes user from updating their own profile', function () {
            $user = User::factory()->create([
                'roles' => [UserRole::HEROES->value],
            ]);

            expect(Gate::forUser($user)->denies('update', $user))->toBeTrue();
        });

        test('denies regular user from updating their own profile', function () {
            $user = User::factory()->create([
                'roles' => [],
            ]);

            expect(Gate::forUser($user)->denies('update', $user))->toBeTrue();
        });
    });
});
