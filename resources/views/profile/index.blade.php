<x-guest-nav-layout>
    <x-slot name="title">My Profile</x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h1>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Stats --}}
                <div class="lg:col-span-3 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div class="bg-white rounded-xl shadow p-4 text-center">
                        <div class="text-2xl font-bold text-indigo-600">{{ $totalBookings }}</div>
                        <div class="text-sm text-gray-500 mt-1">Total</div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-500">{{ $pendingBookings }}</div>
                        <div class="text-sm text-gray-500 mt-1">Pending</div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $confirmedBookings }}</div>
                        <div class="text-sm text-gray-500 mt-1">Confirmed</div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $completedBookings }}</div>
                        <div class="text-sm text-gray-500 mt-1">Completed</div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 text-center">
                        <div class="text-2xl font-bold text-red-500">{{ $cancelledBookings }}</div>
                        <div class="text-sm text-gray-500 mt-1">Cancelled</div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600 text-sm">{{ idr($totalSpent) }}</div>
                        <div class="text-sm text-gray-500 mt-1">Total Spent</div>
                    </div>
                </div>

                {{-- Update Profile --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="font-semibold text-gray-800 mb-4">Personal Information</h2>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Type</label>
                                    <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md text-sm text-gray-600">
                                        @if($user->role === 2)
                                            ⭐ Loyal Customer
                                        @else
                                            👤 Regular Customer
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                    <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md text-sm text-gray-600">
                                        {{ $user->created_at->format('d F Y') }}
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-4 w-full bg-indigo-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Update Password --}}
                <div>
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="font-semibold text-gray-800 mb-4">Change Password</h2>
                        <form method="POST" action="{{ route('profile.password') }}">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" name="current_password"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" name="password"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-4 w-full bg-gray-800 text-white py-2 rounded-lg text-sm font-semibold hover:bg-gray-900">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="mt-6">
                <a href="{{ route('bookings.index') }}" class="text-sm text-indigo-600 hover:underline">
                    ← Back to My Bookings
                </a>
            </div>

        </div>
    </div>
</x-guest-nav-layout>