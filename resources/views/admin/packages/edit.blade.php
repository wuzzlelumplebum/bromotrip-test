<x-admin-layout>
    <x-slot name="title">Edit Tour Package</x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.packages.update', $package->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Package Name</label>
                    <input type="text" name="name" value="{{ old('name', $package->name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">{{ old('description', $package->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Itinerary</label>
                    <textarea name="itinerary" rows="6"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm font-mono">{{ old('itinerary', $package->itinerary) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $package->price) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Duration (Days)</label>
                        <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" min="1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meeting Point</label>
                    <input type="text" name="meeting_point" value="{{ old('meeting_point', $package->meeting_point) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Thumbnail Photo</label>
                    @if($package->thumbnail)
                        <img src="{{ asset('storage/' . $package->thumbnail) }}"
                            class="mt-2 h-24 w-40 object-cover rounded-lg mb-2">
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ $package->is_active ? 'checked' : '' }}
                        class="rounded border-gray-300">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
                    Update Package
                </button>
                <a href="{{ route('admin.packages.index') }}"
                    class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>