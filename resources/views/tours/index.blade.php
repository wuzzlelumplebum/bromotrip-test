<x-guest-nav-layout>
    <x-slot name="title">Tour Packages</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('tours.index') }}" class="bg-white p-4 rounded-lg shadow mb-6 flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Find Package</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Package name..."
                        class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Duration</label>
                    <select name="duration" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                        <option value="">All</option>
                        <option value="1" {{ request('duration') == '1' ? 'selected' : '' }}>1 Day</option>
                        <option value="2" {{ request('duration') == '2' ? 'selected' : '' }}>2 Days</option>
                        <option value="3" {{ request('duration') == '3' ? 'selected' : '' }}>3 Days</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sort By</label>
                    <select name="sort" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Filter
                    </button>
                    <a href="{{ route('tours.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Package Grid --}}
            @if($packages->isEmpty())
                <div class="text-center text-gray-500 py-12">
                    No packages found.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($packages as $package)
                        <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
                            {{-- Thumbnail --}}
                            <div class="h-48 bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center">
                                @if($package->thumbnail)
                                    <img src="{{ asset('storage/' . $package->thumbnail) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-4xl">🏔️</span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-4">
                                <h3 class="font-bold text-lg text-gray-800">{{ $package->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $package->description }}</p>

                                <div class="mt-3 flex items-center gap-3 text-sm text-gray-600">
                                    <span>⏱ {{ $package->duration_days }} Hari</span>
                                    <span>📍 {{ $package->meeting_point }}</span>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-indigo-600 font-bold text-lg">{{ idr($package->price) }}</span>
                                    <a href="{{ route('tours.show', $package->slug) }}"
                                        class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $packages->links() }}
                </div>
            @endif
        </div>
    </div>
</x-guest-nav-layout>