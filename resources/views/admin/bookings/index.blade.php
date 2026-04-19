<x-admin-layout>
    <x-slot name="title">Booking Management</x-slot>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <form method="GET" class="flex gap-3 items-end flex-wrap">
            <div>
                <label class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Booking code or customer..."
                    class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Filter</button>
            <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300">Reset</a>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="pb-3 font-medium">Booking Code</th>
                    <th class="pb-3 font-medium">Customer</th>
                    <th class="pb-3 font-medium">Package</th>
                    <th class="pb-3 font-medium">Date</th>
                    <th class="pb-3 font-medium">Total</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($bookings as $booking)
                    <tr>
                        <td class="py-3 font-mono text-indigo-600">{{ $booking->booking_code }}</td>
                        <td class="py-3 text-gray-700">{{ $booking->user->name }}</td>
                        <td class="py-3 text-gray-700">{{ $booking->tourSchedule->tourPackage->name }}</td>
                        <td class="py-3 text-gray-700">
                            {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->format('d M Y') }}
                        </td>
                        <td class="py-3 text-gray-700">{{ idr($booking->total_price) }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                            ">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                    class="text-xs text-indigo-600 hover:underline">View</a>
                                @if($booking->status === 'pending')
                                    <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-green-600 hover:underline">Confirm</button>
                                    </form>
                                @endif
                                @if($booking->status === 'confirmed')
                                    <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 hover:underline">Complete</button>
                                    </form>
                                @endif
                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking->id) }}"
                                        onsubmit="return confirm('Cancel this booking?')">
                                        @csrf
                                        <button type="submit" class="text-xs text-red-500 hover:underline">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-400">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</x-admin-layout>