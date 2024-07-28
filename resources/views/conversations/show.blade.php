<x-app-layout>
    <section class="max-w-3xl mx-auto mt-8 p-4 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold mb-4 text-center">{{ $thread->subject }}</h1>

        <div class="bg-gray-100 p-4 rounded-lg max-h-96 overflow-y-auto">
            @foreach ($messages as $message)
                <div class="mb-4 flex items-start">
                    @if($message->user->profile_picture)
                        <img src="{{ asset($message->user->profile_picture) }}" alt="{{ $message->user->name }}" class="w-10 h-10 rounded-full mr-4">
                    @else
                        <img src="{{ asset('default-profile.png') }}" alt="Default Profile" class="w-10 h-10 rounded-full mr-4">
                    @endif
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <strong class="block text-sm text-gray-700">{{ $message->user->firstname }}:</strong>
                            <span class="text-xs text-red-750">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                        <p class="bg-blue-100 text-gray-700 p-2 rounded-lg mt-1">{{ $message->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('conversations.reply', $thread->id) }}" method="post" class="mt-4">
            @csrf
            <div class="mb-4">
                <label for="body" class="block text-gray-700 font-medium mb-2">Réponse</label>
                <textarea name="body" id="body" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" required></textarea>
            </div>
            <button type="submit" class="w-full btn-validate">Envoyer</button>
        </form>
    </section>
</x-app-layout>
