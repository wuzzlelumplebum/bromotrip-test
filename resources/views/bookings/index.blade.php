<x-guest-nav-layout>
    <x-slot name="title">My Bookings</x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">My Bookings</h1>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($bookings->isEmpty())
                <div class="bg-white rounded-xl shadow p-12 text-center">
                    <div class="text-6xl mb-4">🏔️</div>
                    <h2 class="text-xl font-semibold text-gray-700">No Bookings Found</h2>
                    <p class="text-gray-500 mt-2 text-sm">Order your first Bromo tour package!</p>
                    <a href="{{ route('tours.index') }}"
                        class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                        View Tour Packages
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-xl shadow p-5 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-mono font-bold text-indigo-600">{{ $booking->booking_code }}</p>
                                    <h3 class="font-semibold text-gray-800 mt-1">
                                        {{ $booking->tourSchedule->tourPackage->name }}
                                    </h3>
                                    <div class="flex gap-4 mt-2 text-sm text-gray-500">
                                        <span>📅 {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->translatedFormat('d F Y') }}</span>
                                        <span>👥 {{ $booking->total_participants }} people</span>
                                        <span>💰 {{ idr($booking->total_price) }}</span>
                                    </div>
                                </div>

                                {{-- Status Badge --}}
                                <span class="px-3 py-1 rounded-full text-xs font-semibold shrink-0
                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                                ">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            {{-- Status Timeline --}}
                            <div class="mt-4 flex items-center gap-2">
                                @php
                                    $steps = ['pending', 'confirmed', 'completed'];
                                    $currentIndex = array_search($booking->status, $steps);
                                @endphp

                                @if($booking->status !== 'cancelled')
                                    @foreach($steps as $i => $step)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs
                                                {{ $i <= $currentIndex ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                                {{ $i + 1 }}
                                            </div>
                                            <span class="text-xs {{ $i <= $currentIndex ? 'text-indigo-600 font-medium' : 'text-gray-400' }}">
                                                {{ ucfirst($step) }}
                                            </span>
                                        </div>
                                        @if(!$loop->last)
                                            <div class="flex-1 h-px {{ $i < $currentIndex ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-xs text-red-500">This booking has been cancelled.</span>
                                @endif
                            </div>

                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('bookings.show', $booking->id) }}"
                                    class="text-sm text-indigo-600 hover:underline">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            @endif

        </div>
    </div>
</x-guest-nav-layout>