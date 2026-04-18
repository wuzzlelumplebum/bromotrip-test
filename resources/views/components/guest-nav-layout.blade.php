<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BromoTrip - {{ $title ?? 'Wisata Bromo' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 font-sans">

        {{-- Navbar --}}
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    {{-- Logo --}}
                    <a href="{{ url('/') }}" class="font-bold text-xl text-indigo-600">
                        🏔️ BromoTrip
                    </a>

                    {{-- Nav Links --}}
                    <div class="flex items-center gap-6">
                        <a href="{{ route('tours.index') }}" class="text-gray-600 hover:text-indigo-600 text-sm font-medium">
                            Tour Packages
                        </a>

                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-indigo-600 text-sm font-medium">
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 text-sm font-medium">
                                    My Bookings
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-600 hover:text-red-500">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 text-sm font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Page Content --}}
        <main>
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t mt-12 py-6 text-center text-sm text-gray-400">
            © {{ date('Y') }} BromoTrip. All rights reserved.
        </footer>

    </body>
    </html>