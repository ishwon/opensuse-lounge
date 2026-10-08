<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(#[CurrentUser] User $user)
    {
        Gate::authorize('view', $user);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(#[CurrentUser] User $user)
    {
        Gate::authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(UpdateUserProfileRequest $request, #[CurrentUser] User $user)
    {
        Gate::authorize('update', $user);

        $data = collect($request->validated());

        // Update email or other simple attributes first
        $user->fill($data->except('password')->toArray());

        // Handle optional password change
        if (filled($password = $data->get('password'))) {
            $user->password = bcrypt($password);
        }

        $user->save();

        return to_route('users.show')
            ->with('success', 'Your profile has been updated successfully!');
    }
}
