@extends('layouts.base')

@section('navigation')
<nav class="bg-card/95 border-b border-default sticky top-0 z-50 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Main Nav -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <img src="/images/logo-with-wordmark.svg"
                            alt="openSUSE"
                            class="h-7 dark:invert transition-transform ">
                    </a>
                </div>

                <!-- Primary Navigation -->
                <div class="hidden sm:ml-8 sm:flex sm:space-x-4">
                    <x-nav-link href="{{ route('members.index') }}" :active="request()->routeIs('members.*')">
                        Members
                    </x-nav-link>
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                @click.away="open = false"
                                class="flex items-center space-x-2 text-sm font-medium text-primary hover:text-brand transition-colors">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-5 w-5 transition-transform"
                                :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 rounded-lg shadow-brand bg-card border border-default py-1">
                            <div class="px-4 py-2 border-b border-default">
                                <p class="text-xs text-secondary">Signed in as</p>
                                <p class="text-sm font-medium text-primary truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->hasRole([\App\Enums\Enums\UserRole::MEMBERSHIP, \App\Enums\Enums\UserRole::ELECTION]))
                                <a href="{{ route('users.show') }}"
                                   class="block px-4 py-2 text-sm text-primary hover:bg-card-hover transition-colors mt-1">
                                    Your Profile
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-primary hover:bg-card-hover transition-colors">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
@endsection

@section('main')
<main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex- z-10">
    @yield('content')
</main>
@endsection
