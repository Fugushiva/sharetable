<x-app-layout>
    <section class="p-6 mt-6 bg-white rounded-lg w-3/4 mx-auto shadow-lg">
        <h1 class="text-2xl font-semibold mb-4 text-center">Envoyer un message à {{ $recipient->firstname }} {{ $recipient->lastname }}</h1>

        <form action="{{ route('conversations.store') }}" method="post">
            @csrf
            <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">

            <div class="mb-4">
                <label for="body" class="block text-gray-700 font-medium mb-2">Message</label>
                <textarea name="body" id="body" class="input" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-validate w-full">Envoyer</button>
        </form>
    </section>
</x-app-layout>
