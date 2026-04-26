<x-guest-nav-layout>
    <x-slot name="title">Page Not Found</x-slot>

    <div class="min-h-[60vh] flex items-center justify-center py-16">
        <div class="text-center px-4">
            <div class="text-8xl font-extrabold text-indigo-600 mb-4">404</div>
            <div class="text-6xl mb-6">🏔️</div>
            <h1 class="text-2xl font-bold text-gray-800 mb-3">Page Not Found</h1>
            <p class="text-gray-500 max-w-md mx-auto mb-8">
                Looks like you've wandered off the trail! The page you're looking for doesn't exist or has been moved.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('home') }}"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
                    Back to Home
                </a>
                <a href="{{ route('tours.index') }}"
                    class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                    Browse Tours
                </a>
            </div>
        </div>
    </div>

</x-guest-nav-layout>