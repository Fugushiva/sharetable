<x-app-layout>
    <div class="flex flex-col items-center mt-8 text-center gap-6 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-4xl font-bold">Become a Host</h1>
        <p class="text-lg text-gray-700">Sharing a meal is an intimate experience. Guests will be able to see your profile and the meals you've hosted.</p>
        <div class="w-full">
            <p class="font-bold text-2xl text-gray-800">Profile Photo</p>
            <p class="text-lg text-gray-700">Your profile photo is the first thing guests see when they visit your profile. It should be a clear, high-resolution photo of you. Avoid using group photos or photos with filters.</p>
        </div>
    </div>

    <div class="w-full flex flex-col gap-8 mt-6 p-6 bg-white shadow-lg rounded-lg">
        <form enctype="multipart/form-data" method="post" action="{{ route('host.store') }}" class="space-y-6">
            @csrf

            <!-- Description -->
            <div class="flex flex-col">
                <label for="bio" class="mb-2 text-lg font-medium text-gray-700">Description</label>
                <textarea id="bio" name="bio" class="input"></textarea>
                @error('bio')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div class="flex flex-col">
                <label for="birthdate" class="mb-2 text-lg font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="birthdate" id="birthdate" class="input">
                @error('birthdate')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!--Profile picture-->
            <div class="flex flex-col">
                <label for="picture">Photo de profil</label>
                <input type="file" name="profile_picture" id="picture">
                @error('profile_picture')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                @if(!empty($host->profile_picture))
                    <img src="{{ image_path($host->profile_picture) }}" alt="Profile picture" class="w-1/4 rounded-full">
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-1/4 btn-validate">
                Become a Host
            </button>
        </form>

    </div>
    <x-footer />
</x-app-layout>
