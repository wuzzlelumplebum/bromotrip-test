<x-admin-layout>
    <x-slot name="title">Edit Booking</x-slot>

    <div class="max-w-3xl">

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}">
            @csrf @method('PUT')

            {{-- Booking Info --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-gray-800 mb-1">Booking Info</h2>
                <p class="text-indigo-600 font-mono font-bold">{{ $booking->booking_code }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $booking->tourSchedule->tourPackage->name }} —
                    {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->format('d F Y') }}
                </p>
            </div>

            {{-- Participant Details --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-gray-800 mb-4">Participant Details</h2>
                <div class="space-y-6">
                    @foreach($booking->participants as $i => $participant)
                        <div class="border rounded-lg p-4">
                            <h3 class="font-medium text-gray-700 mb-3">Participant {{ $i + 1 }}</h3>
                            <input type="hidden" name="participants[{{ $participant->id }}][id]" value="{{ $participant->id }}">
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="participants[{{ $participant->id }}][name]"
                                        value="{{ old('participants.' . $participant->id . '.name', $participant->name) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">ID Type</label>
                                        <select name="participants[{{ $participant->id }}][id_type]"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                            <option value="ktp" {{ $participant->id_type === 'ktp' ? 'selected' : '' }}>KTP</option>
                                            <option value="passport" {{ $participant->id_type === 'passport' ? 'selected' : '' }}>Passport</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">ID Number</label>
                                        <input type="text" name="participants[{{ $participant->id }}][id_number]"
                                            value="{{ old('participants.' . $participant->id . '.id_number', $participant->id_number) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <input type="date" name="participants[{{ $participant->id }}][birth_date]"
                                        value="{{ old('participants.' . $participant->id . '.birth_date', $participant->birth_date) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Notes --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-gray-800 mb-4">Notes</h2>
                <textarea name="notes" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm text-sm">{{ old('notes', $booking->notes) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                    class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>