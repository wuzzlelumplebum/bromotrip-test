<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-indigo-600">{{ $totalBookings }}</div>
            <div class="text-xs text-gray-500 mt-1">Total Bookings</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-yellow-500">{{ $pendingBookings }}</div>
            <div class="text-xs text-gray-500 mt-1">Pending</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $confirmedBookings }}</div>
            <div class="text-xs text-gray-500 mt-1">Confirmed</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-purple-600 text-sm">{{ idr($totalRevenue) }}</div>
            <div class="text-xs text-gray-500 mt-1">Revenue</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $totalPackages }}</div>
            <div class="text-xs text-gray-500 mt-1">Packages</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <div class="text-2xl font-bold text-pink-600">{{ $totalCustomers }}</div>
            <div class="text-xs text-gray-500 mt-1">Customers</div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-800">Recent Bookings</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-indigo-600 hover:underline">
                View All →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3 font-medium">Booking Code</th>
                        <th class="pb-3 font-medium">Customer</th>
                        <th class="pb-3 font-medium">Package</th>
                        <th class="pb-3 font-medium">Total</th>
                        <th class="pb-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td class="py-3 font-mono text-indigo-600">{{ $booking->booking_code }}</td>
                            <td class="py-3 text-gray-700">{{ $booking->user->name }}</td>
                            <td class="py-3 text-gray-700">{{ $booking->tourSchedule->tourPackage->name }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400">No bookings yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>