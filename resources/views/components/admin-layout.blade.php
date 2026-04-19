<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BromoTrip Admin - {{ $title ?? 'Dashboard' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 font-sans">

        <div class="flex h-screen overflow-hidden">

            {{-- Sidebar --}}
            <aside class="w-64 bg-indigo-800 text-white flex flex-col shrink-0">
                {{-- Logo --}}
                <div class="px-6 py-5 border-b border-indigo-700">
                    <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl">
                        🏔️ BromoTrip
                    </a>
                    <p class="text-indigo-300 text-xs mt-1">Admin Panel</p>
                </div>

                {{-- Nav --}}
                <nav class="flex-1 px-4 py-6 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                        {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700 hover:text-white' }}">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('admin.packages.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                        {{ request()->routeIs('admin.packages.*') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700 hover:text-white' }}">
                        🏔️ Tour Packages
                    </a>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                        {{ request()->routeIs('admin.bookings.*') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700 hover:text-white' }}">
                        📋 Bookings
                    </a>
                    <a href="{{ route('admin.reports.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                        {{ request()->routeIs('admin.reports.*') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700 hover:text-white' }}">
                        📈 Reports
                    </a>
                </nav>

                {{-- User & Logout --}}
                <div class="px-4 py-4 border-t border-indigo-700">
                    <p class="text-indigo-300 text-xs mb-2">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-indigo-300 hover:text-white">
                            → Logout
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Main Content --}}
            <div class="flex-1 flex flex-col overflow-hidden">
                {{-- Top Bar --}}
                <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between shrink-0">
                    <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
                    <span class="text-sm text-gray-500">{{ now()->format('d F Y') }}</span>
                </header>

                {{-- Page Content --}}
                <main class="flex-1 overflow-y-auto p-6">
                    {{ $slot }}
                </main>
            </div>

        </div>

    </body>
</html>