<x-admin-layout>
    <x-slot name="title">Schedules - {{ $package->name }}</x-slot>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Schedule List --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Schedules for {{ $package->name }}</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3 font-medium">Departure Date</th>
                        <th class="pb-3 font-medium">Quota</th>
                        <th class="pb-3 font-medium">Booked</th>
                        <th class="pb-3 font-medium">Available</th>
                        <th class="pb-3 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($schedules as $schedule)
                        <tr>
                            <td class="py-3 text-gray-700">
                                {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}
                            </td>
                            <td class="py-3 text-gray-700">{{ $schedule->quota }}</td>
                            <td class="py-3 text-gray-700">{{ $schedule->booked }}</td>
                            <td class="py-3 text-gray-700">{{ $schedule->availableQuota() }}</td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}"
                                    onsubmit="return confirm('Delete this schedule?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400">No schedules yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $schedules->links() }}</div>
        </div>

        {{-- Add Schedule Form --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Add Schedule</h2>
            <form method="POST" action="{{ route('admin.packages.schedules.store', $package->id) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Departure Date</label>
                        <input type="date" name="departure_date"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                        @error('departure_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quota</label>
                        <input type="number" name="quota" value="20" min="1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                        @error('quota')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit"
                    class="mt-4 w-full bg-indigo-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
                    Add Schedule
                </button>
            </form>
            <div class="mt-4">
                <a href="{{ route('admin.packages.index') }}" class="text-sm text-indigo-600 hover:underline">
                    ← Back to Packages
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>