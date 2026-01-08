<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Role-Specific Profile Display -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @php
                $userRole = Auth::user()->role;
                @endphp

                @if($userRole === 'kepala_badan')
                @include('profile.partials.profile-kepala-badan', compact('user', 'incomingTotal', 'outgoingTotal', 'pendingApproval', 'inProgress'))
                @elseif($userRole === 'sekretaris')
                @include('profile.partials.profile-sekretaris', compact('user', 'incomingTotal', 'outgoingTotal', 'incomingProcessed', 'pendingApproval'))
                @elseif($userRole === 'admin')
                @include('profile.partials.profile-admin', compact('user', 'incomingTotal', 'outgoingTotal', 'pendingLetters', 'archivedCount'))
                @else
                <!-- Default profile for other roles -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-8 text-white">
                        <div class="flex items-center gap-4">
                            <div class="w-24 h-24 rounded-full bg-orange-300 flex items-center justify-center text-4xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold">{{ $user->name }}</h2>
                                <p class="text-orange-100 mt-1">{{ Auth::user()->roleLabel() }}</p>
                                <p class="text-xs text-orange-100 mt-2">NIP: {{ $user->nip ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Informasi Pribadi</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                    <p class="text-gray-900 font-semibold mt-1">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Email</label>
                                    <p class="text-gray-900 font-semibold mt-1">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Username</label>
                                    <p class="text-gray-900 font-semibold mt-1">{{ $user->username }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Informasi Akun</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Peran</label>
                                    <p class="text-gray-900 font-semibold mt-1">{{ Auth::user()->roleLabel() }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Status</label>
                                    <div class="mt-1">
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">Aktif</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Bergabung Sejak</label>
                                    <p class="text-gray-900 font-semibold mt-1">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Edit Profile Form -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Form -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>