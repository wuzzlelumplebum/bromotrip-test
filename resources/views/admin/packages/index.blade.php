<x-admin-layout>
    <x-slot name="title">Tour Packages</x-slot>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-800">All Packages</h2>
            <a href="{{ route('admin.packages.create') }}"
                class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700">
                + Add Package
            </a>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="pb-3 font-medium">Package</th>
                    <th class="pb-3 font-medium">Price</th>
                    <th class="pb-3 font-medium">Duration</th>
                    <th class="pb-3 font-medium">Schedules</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($packages as $package)
                    <tr>
                        <td class="py-3">
                            <div class="font-medium text-gray-800">{{ $package->name }}</div>
                            <div class="text-gray-400 text-xs">{{ $package->meeting_point }}</div>
                        </td>
                        <td class="py-3 text-gray-700">{{ idr($package->price) }}</td>
                        <td class="py-3 text-gray-700">{{ $package->duration_days }} Day(s)</td>
                        <td class="py-3 text-gray-700">{{ $package->schedules_count }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $package->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $package->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.packages.schedules', $package->id) }}"
                                    class="text-xs text-blue-600 hover:underline">Schedules</a>
                                <a href="{{ route('admin.packages.edit', $package->id) }}"
                                    class="text-xs text-indigo-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $package->id) }}"
                                    onsubmit="return confirm('Delete this package?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-400">No packages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $packages->links() }}</div>
    </div>
</x-admin-layout>