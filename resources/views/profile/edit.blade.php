<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information -->
            <div class="p-6 bg-gray-800 text-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold text-gray-200 mb-4">Profile Information</h3>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full text-sm bg-gray-700 text-gray-200 border-gray-500 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
                            Save
                        </button>
                    </form>
                </div>
            </div>

            <!-- Upload Avatar -->
            <div class="p-6 bg-gray-800 text-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold text-gray-200 mb-4">Upload Avatar</h3>
                    <form method="POST" action="{{ route('profile.update.avatar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="avatar" class="block text-sm font-medium text-gray-300">Choose an image</label>
                            <input type="file" name="avatar" id="avatar"
                                class="mt-1 block w-full text-sm bg-gray-700 text-gray-200 border-gray-500 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('avatar')
                                <p class="text-sm text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150">
                            Update Avatar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Delete Avatar -->
            <div class="p-6 bg-gray-800 text-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold text-gray-200 mb-4">Delete Avatar</h3>
                    <form method="POST" action="{{ route('profile.delete.avatar') }}">
                        @csrf
                        @method('delete')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-150">
                            Delete Avatar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
