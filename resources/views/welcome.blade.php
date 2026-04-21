<x-guest-nav-layout>
    <x-slot name="title">Welcome to BromoTrip</x-slot>

    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-br from-indigo-700 via-indigo-600 to-blue-500 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-24 sm:py-32 text-center relative z-10">
            <h1 class="text-5xl font-extrabold leading-tight mb-4">
                Discover the Magic of <br> Mount Bromo
            </h1>
            <p class="text-indigo-100 text-xl max-w-2xl mx-auto mb-8">
                Experience breathtaking sunrises, volcanic landscapes, and unforgettable adventures in the heart of East Java.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('tours.index') }}"
                    class="bg-white text-indigo-600 font-semibold px-8 py-3 rounded-xl hover:bg-indigo-50 transition">
                    Explore Packages
                </a>
                @guest
                    <a href="{{ route('register') }}"
                        class="border border-white text-white font-semibold px-8 py-3 rounded-xl hover:bg-white/10 transition">
                        Get Started
                    </a>
                @endguest
            </div>
            {{-- Search Bar --}}
            <div class="mt-8 max-w-lg mx-auto">
                <form method="GET" action="{{ route('tours.index') }}"
                    class="flex gap-2 bg-white rounded-xl p-2 shadow-lg">
                    <input type="text" name="search"
                        placeholder="Search tour packages..."
                        class="flex-1 px-4 py-2 text-gray-800 text-sm rounded-lg border-0 focus:ring-0 outline-none">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                        Search
                    </button>
                </form>
            </div>
        </div>

        {{-- Decorative circles --}}
        <div class="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-1/3 translate-y-1/3"></div>
    </div>

    {{-- Stats Section --}}
    <div class="bg-white py-12 border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $totalPackages }}</div>
                    <div class="text-gray-500 mt-1 text-sm">Tour Packages</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-indigo-600">100+</div>
                    <div class="text-gray-500 mt-1 text-sm">Happy Travelers</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-indigo-600">5★</div>
                    <div class="text-gray-500 mt-1 text-sm">Average Rating</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-indigo-600">10+</div>
                    <div class="text-gray-500 mt-1 text-sm">Local Guides</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Featured Packages --}}
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Our Tour Packages</h2>
                <p class="text-gray-500 mt-2">Choose the perfect adventure for you</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($packages as $package)
                    <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center">
                            @if($package->thumbnail)
                                <img src="{{ asset('storage/' . $package->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-white text-5xl">🏔️</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-800">{{ $package->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $package->description }}</p>
                            <div class="mt-3 flex items-center gap-3 text-sm text-gray-600">
                                <span>⏱ {{ $package->duration_days }} Day(s)</span>
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
            <div class="text-center mt-8">
                <a href="{{ route('tours.index') }}"
                    class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-indigo-700">
                    View All Packages
                </a>
            </div>
        </div>
    </div>

    {{-- Why Choose Us --}}
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Why Choose BromoTrip?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="text-4xl mb-4">🧭</div>
                    <h3 class="font-bold text-gray-800 text-lg">Expert Local Guides</h3>
                    <p class="text-gray-500 text-sm mt-2">Our guides are born and raised around Bromo, ensuring the most authentic experience.</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-4">🛡️</div>
                    <h3 class="font-bold text-gray-800 text-lg">Safe & Reliable</h3>
                    <p class="text-gray-500 text-sm mt-2">Your safety is our top priority. All tours follow strict safety protocols.</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="font-bold text-gray-800 text-lg">Best Price Guarantee</h3>
                    <p class="text-gray-500 text-sm mt-2">We offer competitive prices without compromising on quality or experience.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    @guest
    <div class="bg-indigo-600 py-16 text-white text-center">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-4">Ready for Your Adventure?</h2>
            <p class="text-indigo-100 mb-8">Join thousands of travelers who have experienced the magic of Mount Bromo with us.</p>
            <a href="{{ route('register') }}"
                class="bg-white text-indigo-600 font-semibold px-8 py-3 rounded-xl hover:bg-indigo-50 transition">
                Create Free Account
            </a>
        </div>
    </div>
    @endguest

</x-guest-nav-layout>