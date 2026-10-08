@extends('layouts.authenticated')

@section('content')
<div class="max-w-3xl space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-primary">Your Profile</h1>
            <p class="mt-1 text-sm text-secondary">
                View and manage your account information
            </p>
        </div>
        <x-button href="{{ route('members.index') }}" variant="ghost">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </x-button>
    </div>

    <!-- Profile Card -->
    <x-card title="Profile Information">
        <!-- Basic Information Section -->
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-primary border-b border-default pb-2">
                Basic Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-primary">Name</label>
                    <p class="mt-1 text-sm text-primary">{{ $user->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-primary">Email</label>
                    <p class="mt-1 text-sm text-primary">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Roles Section -->
        <div class="space-y-4 mt-6">
            <h3 class="text-lg font-medium text-primary border-b border-default pb-2">
                Account Information
            </h3>

            <div>
                <label class="block text-sm font-medium text-primary">Roles</label>
                <div class="mt-1 flex flex-wrap gap-2">
                    @foreach($user->roles as $role)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand/10 text-brand">
                            {{ ucfirst(strtolower($role)) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-default mt-6">
            <x-button variant="primary" href="{{ route('users.edit') }}">
                Edit Profile
            </x-button>
        </div>
    </x-card>
</div>
@endsection