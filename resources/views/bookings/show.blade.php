<x-guest-nav-layout>
    <x-slot name="title">Booking Details</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Booking Header --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Booking Details</h1>
                        <p class="text-indigo-600 font-mono font-bold text-lg mt-1">{{ $booking->booking_code }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                    ">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            {{-- Info Paket --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-gray-800 mb-4">Package Information</h2>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Package</span>
                        <span class="font-medium text-gray-800">{{ $booking->tourSchedule->tourPackage->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Departure Date</span>
                        <span class="font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Participants</span>
                        <span class="font-medium text-gray-800">{{ $booking->total_participants }} people</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Meeting Point</span>
                        <span class="font-medium text-gray-800">{{ $booking->tourSchedule->tourPackage->meeting_point }}</span>
                    </div>
                    <hr>
                    <div class="flex justify-between text-base">
                        <span class="font-semibold text-gray-800">Total Price</span>
                        <span class="font-bold text-indigo-600">{{ idr($booking->total_price) }}</span>
                    </div>
                </div>
            </div>

            {{-- Data Peserta --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-gray-800 mb-4">Participant Details</h2>
                <div class="space-y-3">
                    @foreach($booking->participants as $i => $participant)
                        <div class="border rounded-lg p-3 text-sm">
                            <div class="font-medium text-gray-800">{{ $i + 1 }}. {{ $participant->name }}</div>
                            <div class="text-gray-500 mt-1">
                                {{ strtoupper($participant->id_type) }}: {{ $participant->id_number }} •
                                {{ \Carbon\Carbon::parse($participant->birth_date)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($booking->notes)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="font-semibold text-gray-800 mb-2">Notes</h2>
                    <p class="text-sm text-gray-600">{{ $booking->notes }}</p>
                </div>
            @endif

            <div class="flex gap-3">
                <a href="{{ route('bookings.index') }}"
                    class="flex-1 text-center bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700">
                    My Bookings
                </a>
                <a href="{{ route('tours.index') }}"
                    class="flex-1 text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200">
                    Browse More Packages
                </a>
            </div>
            @if($booking->status === 'pending')
                <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <button type="button" onclick="confirmCancel()"
                        class="w-full bg-red-50 text-red-600 py-3 rounded-xl font-semibold hover:bg-red-100 transition border border-red-200">
                        Cancel Booking
                    </button>
                </form>
                <script>
                    function confirmCancel() {
                        if (confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
                            document.querySelector('form[action*="cancel"]').submit();
                        }
                    }
                </script>
            @endif
        </div>
    </div>
</x-guest-nav-layout>