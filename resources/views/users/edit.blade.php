@extends('layouts.authenticated')

@section('content')
<div class="max-w-3xl space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-primary">Edit Profile</h1>
            <p class="mt-1 text-sm text-secondary">
                Update your account information
            </p>
        </div>
        <x-button href="{{ route('users.show') }}" variant="ghost">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </x-button>
    </div>

    <!-- Edit Profile Card -->
    <x-card title="Profile Information">
        @if ($errors->any())
            <x-alert type="error" :dismissible="false">
                <p class="font-medium mb-2">There were errors with your submission</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form method="POST" action="{{ route('users.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-primary border-b border-default pb-2">
                    Basic Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input
                        label="Name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        readonly
                        helpText="Name cannot be changed"
                    />

                    <x-input
                        label="Email Address"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        placeholder="Enter your email address"
                        required
                        autofocus
                    />
                </div>
            </div>

            <!-- Password Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-primary border-b border-default pb-2">
                    Change Password
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input
                        label="New Password (Optional)"
                        name="password"
                        type="password"
                        placeholder="Enter a new password"
                        helpText="Leave blank to keep your current password"
                    />

                    <x-input
                        label="Confirm New Password"
                        name="password_confirmation"
                        type="password"
                        placeholder="Confirm your new password"
                    />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-default">
                <x-button href="{{ route('users.show') }}" variant="ghost">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update Profile
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection