<x-admin-layout>
    <x-slot name="title">Reports</x-slot>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <form method="GET" class="flex gap-3 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Month</label>
                <input type="month" name="month" value="{{ $month }}"
                    class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                Generate Report
            </button>
        </form>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-indigo-600">{{ $totalBookings }}</div>
            <div class="text-xs text-gray-500 mt-1">Total Bookings</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-yellow-500">{{ $pendingCount }}</div>
            <div class="text-xs text-gray-500 mt-1">Pending</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $confirmedCount }}</div>
            <div class="text-xs text-gray-500 mt-1">Confirmed</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $completedCount }}</div>
            <div class="text-xs text-gray-500 mt-1">Completed</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-red-500">{{ $cancelledCount }}</div>
            <div class="text-xs text-gray-500 mt-1">Cancelled</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-purple-600 text-sm">{{ idr($totalRevenue) }}</div>
            <div class="text-xs text-gray-500 mt-1">Revenue</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Revenue by Package --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Revenue by Package</h2>
            @if($revenueByPackage->isEmpty())
                <p class="text-sm text-gray-400">No data for this month.</p>
            @else
                <div class="space-y-3">
                    @foreach($revenueByPackage as $name => $data)
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <div class="font-medium text-gray-800">{{ $name }}</div>
                                <div class="text-gray-400 text-xs">{{ $data['count'] }} bookings</div>
                            </div>
                            <span class="font-bold text-indigo-600">{{ idr($data['revenue']) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Booking List --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">
                Bookings — {{ \Carbon\Carbon::parse($month)->format('F Y') }}
            </h2>
            @if($bookings->isEmpty())
                <p class="text-sm text-gray-400 text-center py-6">No bookings for this month.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-3 font-medium">Code</th>
                            <th class="pb-3 font-medium">Customer</th>
                            <th class="pb-3 font-medium">Package</th>
                            <th class="pb-3 font-medium">Total</th>
                            <th class="pb-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="py-2 font-mono text-indigo-600 text-xs">{{ $booking->booking_code }}</td>
                                <td class="py-2 text-gray-700">{{ $booking->user->name }}</td>
                                <td class="py-2 text-gray-700">{{ $booking->tourSchedule->tourPackage->name }}</td>
                                <td class="py-2 text-gray-700">{{ idr($booking->total_price) }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                                    ">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</x-admin-layout>