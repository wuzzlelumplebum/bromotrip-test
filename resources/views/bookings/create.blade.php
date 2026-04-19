<x-guest-nav-layout>
    <x-slot name="title">Booking - {{ $package->name }}</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Header --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h1 class="text-xl font-bold text-gray-800">Booking Form</h1>
                <p class="text-gray-500 text-sm mt-1">{{ $package->name }}</p>
                <div class="mt-3 flex gap-4 text-sm text-gray-600">
                    <span>📅 {{ \Carbon\Carbon::parse($schedule->departure_date)->translatedFormat('d F Y') }}</span>
                    <span>👥 {{ $schedule->availableQuota() }} spots remaining</span>
                    <span>💰 {{ idr($package->price) }}/person</span>
                </div>
                @if(auth()->user()->role === 2)
                    <div class="mt-2 text-sm text-green-600 font-medium">
                        🎉 You get a 10% discount as a Loyal Customer!
                    </div>
                @endif
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('bookings.store', $schedule->id) }}" id="bookingForm">
                @csrf

                {{-- Jumlah Peserta --}}
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="font-semibold text-gray-800 mb-4">Number of Participants</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Participants</label>
                        <input type="number" name="total_participants" id="totalParticipants"
                            min="1" max="{{ $schedule->availableQuota() }}"
                            value="{{ old('total_participants', 1) }}"
                            class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm text-sm"
                            onchange="updateParticipantForms()">
                        @error('total_participants')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Total Harga --}}
                    <div class="mt-4 p-3 bg-indigo-50 rounded-lg">
                        <span class="text-sm text-gray-600">Total Price: </span>
                        <span class="font-bold text-indigo-600" id="totalPrice">{{ idr($package->price) }}</span>
                    </div>
                </div>

                {{-- Data Peserta --}}
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="font-semibold text-gray-800 mb-4">Participant Details</h2>
                    <div id="participantForms" class="space-y-6">
                        {{-- Diisi oleh JavaScript --}}
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="font-semibold text-gray-800 mb-4">Notes (optional)</h2>
                    <textarea name="notes" rows="3"
                        placeholder="Example: there are participants with allergies, special needs, etc."
                        class="block w-full rounded-md border-gray-300 shadow-sm text-sm">{{ old('notes') }}</textarea>
                </div>

                <button type="button" onclick="confirmBooking() "class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
                    Confirm Booking
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('tours.show', $package->slug) }}" class="text-sm text-indigo-600 hover:underline">
                    ← Back to Package Details
                </a>
            </div>
        </div>
    </div>

    <script>
        const pricePerPerson = {{ $package->price }};
        const isLoyal = {{ auth()->user()->role === 2 ? 'true' : 'false' }};
        const effectivePrice = isLoyal ? pricePerPerson * 0.9 : pricePerPerson;

        function formatIDR(amount) {
            return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
        }

        function updateParticipantForms() {
            const count = parseInt(document.getElementById('totalParticipants').value) || 1;
            const container = document.getElementById('participantForms');
            container.innerHTML = '';

            for (let i = 0; i < count; i++) {
                container.innerHTML += `
                    <div class="border rounded-lg p-4">
                        <h3 class="font-medium text-gray-700 mb-3">Participant ${i + 1}</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block text-sm text-gray-600">Full Name</label>
                                <input type="text" name="participants[${i}][name]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm text-gray-600">ID Type</label>
                                    <select name="participants[${i}][id_type]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                        <option value="ktp">KTP</option>
                                        <option value="passport">Passport</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600">ID Number</label>
                                    <input type="text" name="participants[${i}][id_number]" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600">Date of Birth</label>
                                <input type="date" name="participants[${i}][birth_date]" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                            </div>
                        </div>
                    </div>
                `;
            }

            document.getElementById('totalPrice').textContent = formatIDR(effectivePrice * count);
        }

        function confirmBooking() {
            const count = parseInt(document.getElementById('totalParticipants').value) || 1;
            const total = document.getElementById('totalPrice').textContent;

            const confirmed = confirm(
                `Please confirm your booking:\n\n` +
                `Package: {{ $package->name }}\n` +
                `Date: {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}\n` +
                `Participants: ${count} people\n` +
                `Total Price: ${total}\n\n` +
                `Proceed with booking?`
            );

            if (confirmed) {
                document.getElementById('bookingForm').submit();
            }
        }

        // Init saat halaman load
        updateParticipantForms();
    </script>
</x-guest-nav-layout>