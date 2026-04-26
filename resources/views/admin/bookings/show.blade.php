<x-admin-layout>
    <x-slot name="title">Booking Detail</x-slot>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            {{-- Booking Info --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-semibold text-gray-800">Booking Details</h2>
                        <p class="font-mono font-bold text-indigo-600 text-lg">{{ $booking->booking_code }}</p>
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
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Package</span>
                        <span class="font-medium text-gray-800">{{ $booking->tourSchedule->tourPackage->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Departure Date</span>
                        <span class="font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->format('d F Y') }}
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
                    @if($booking->notes)
                        <div class="flex justify-between">
                            <span>Notes</span>
                            <span class="font-medium text-gray-800">{{ $booking->notes }}</span>
                        </div>
                    @endif
                    <hr>
                    <div class="flex justify-between text-base">
                        <span class="font-semibold text-gray-800">Total Price</span>
                        <span class="font-bold text-indigo-600">{{ idr($booking->total_price) }}</span>
                    </div>
                </div>
            </div>

            {{-- Participants --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Participant Details</h2>
                <div class="space-y-3">
                    @foreach($booking->participants as $i => $participant)
                        <div class="border rounded-lg p-3 text-sm">
                            <div class="font-medium text-gray-800">{{ $i + 1 }}. {{ $participant->name }}</div>
                            <div class="text-gray-500 mt-1">
                                {{ strtoupper($participant->id_type) }}: {{ $participant->id_number }} •
                                {{ \Carbon\Carbon::parse($participant->birth_date)->format('d F Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="space-y-4">
            {{-- Customer Info --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Customer Info</h2>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Name</span>
                        <span class="font-medium text-gray-800">{{ $booking->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Email</span>
                        <span class="font-medium text-gray-800">{{ $booking->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Account Type</span>
                        <span class="font-medium text-gray-800">
                            {{ $booking->user->role === 2 ? '⭐ Loyal Customer' : '👤 Regular' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-3">
                <h2 class="font-semibold text-gray-800 mb-2">Actions</h2>
                <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                    class="w-full block text-center bg-indigo-50 text-indigo-600 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-100 border border-indigo-200 mb-3">
                    ✏️ Edit Booking
                </a>
                @if($booking->status === 'pending')
                    <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-green-700">
                            ✅ Confirm Booking
                        </button>
                    </form>
                @endif
                @if($booking->status === 'confirmed')
                    <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
                            🏁 Mark as Completed
                        </button>
                    </form>
                @endif
                @if(in_array($booking->status, ['pending', 'confirmed']))
                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking->id) }}"
                        onsubmit="return confirm('Cancel this booking?')">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-50 text-red-600 py-2 rounded-lg text-sm font-semibold hover:bg-red-100 border border-red-200">
                            ❌ Cancel Booking
                        </button>
                    </form>
                @endif
            </div>

            <a href="{{ route('admin.bookings.index') }}" class="block text-sm text-indigo-600 hover:underline text-center">
                ← Back to Bookings
            </a>
        </div>
    </div>
</x-admin-layout>