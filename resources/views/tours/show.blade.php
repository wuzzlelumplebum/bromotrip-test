<x-guest-nav-layout>
    <x-slot name="title">{{ $package->name }}</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Kolom Kiri: Info Paket --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Thumbnail --}}
                    <div class="h-72 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-xl flex items-center justify-center overflow-hidden">
                        @if($package->thumbnail)
                            <img src="{{ asset('storage/' . $package->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-8xl">🏔️</span>
                        @endif
                    </div>

                    {{-- Info Umum --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $package->name }}</h1>
                        <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-600">
                            <span>⏱ {{ $package->duration_days }} Days</span>
                            <span>📍 {{ $package->meeting_point }}</span>
                            <span>👥 Max. 20 people/schedule</span>
                        </div>
                        <p class="mt-4 text-gray-600 leading-relaxed">{{ $package->description }}</p>
                    </div>

                    {{-- Itinerary --}}
                    @if($package->itinerary)
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">📋 Itinerary</h2>
                        <div class="space-y-2">
                            @foreach(explode("\n", $package->itinerary) as $line)
                                @if(trim($line))
                                    <div class="flex gap-3 text-sm text-gray-700">
                                        @if(str_contains($line, 'Day'))
                                            <span class="font-bold text-indigo-600 w-full">{{ $line }}</span>
                                        @else
                                            <span class="text-indigo-400 mt-0.5">•</span>
                                            <span>{{ $line }}</span>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Kolom Kanan: Harga & Jadwal --}}
                <div class="space-y-4">

                    {{-- Harga --}}
                    <div class="bg-white rounded-xl shadow p-6 sticky top-20">
                        <div class="text-3xl font-bold text-indigo-600">{{ idr($package->price) }}</div>
                        <p class="text-sm text-gray-500 mt-1">per person</p>

                        <hr class="my-4">

                        <h3 class="font-semibold text-gray-800 mb-3">Select Schedule</h3>

                        @if($package->schedules->isEmpty())
                            <p class="text-sm text-gray-400">No schedules available.</p>
                        @else
                            <div class="space-y-2">
                                @foreach($package->schedules as $schedule)
                                    <div class="border rounded-lg p-3 text-sm
                                        {{ $schedule->availableQuota() > 0 ? 'border-indigo-200 hover:border-indigo-400 cursor-pointer' : 'border-gray-100 opacity-50' }}">
                                        <div class="font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($schedule->departure_date)->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="text-gray-500 mt-0.5">
                                            Remaining: {{ $schedule->availableQuota() }} spots
                                        </div>
                                        @if($schedule->availableQuota() > 0)
                                            <a href="{{ route('bookings.create', $schedule->id) }}"
                                                class="mt-2 block text-center bg-indigo-600 text-white py-1.5 rounded-md hover:bg-indigo-700 text-xs font-medium">
                                                Book Now
                                            </a>
                                        @else
                                            <span class="mt-2 block text-center bg-gray-200 text-gray-400 py-1.5 rounded-md text-xs">
                                                Fully Booked
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Back Button --}}
            <div class="mt-6">
                <a href="{{ route('tours.index') }}" class="text-indigo-600 hover:underline text-sm">
                    ← Back to Package List
                </a>
            </div>

        </div>
    </div>
</x-guest-nav-layout>