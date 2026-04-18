<x-guest-nav-layout>
    <x-slot name="title">Detail Booking</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Booking Header --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Detail Booking</h1>
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
                <h2 class="font-semibold text-gray-800 mb-4">Info Paket</h2>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Paket</span>
                        <span class="font-medium text-gray-800">{{ $booking->tourSchedule->tourPackage->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tanggal Keberangkatan</span>
                        <span class="font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Jumlah Peserta</span>
                        <span class="font-medium text-gray-800">{{ $booking->total_participants }} orang</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Meeting Point</span>
                        <span class="font-medium text-gray-800">{{ $booking->tourSchedule->tourPackage->meeting_point }}</span>
                    </div>
                    <hr>
                    <div class="flex justify-between text-base">
                        <span class="font-semibold text-gray-800">Total Harga</span>
                        <span class="font-bold text-indigo-600">{{ idr($booking->total_price) }}</span>
                    </div>
                </div>
            </div>

            {{-- Data Peserta --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-gray-800 mb-4">Data Peserta</h2>
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
                    <h2 class="font-semibold text-gray-800 mb-2">Catatan</h2>
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
                    Lihat Paket Lain
                </a>
            </div>

        </div>
    </div>
</x-guest-nav-layout>