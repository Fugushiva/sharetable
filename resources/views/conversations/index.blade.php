<x-app-layout>
    <section class="max-w-2xl mx-auto mt-8 p-4 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold mb-4 text-center">{{__('profile.conversation.title')}}</h1>
        @if($threads->isEmpty())
            <p class="text-gray-500 text-center">{{__('profile.conversation.no_conversation')}}</p>
        @else
            <ul class="space-y-4">
                @foreach($threads as $thread)
                    @php
                        $participant = $thread->participants()->where('user_id', '!=', Auth::id())->first();
                        $participantUser = $participant ? $participant->user : null;
                    @endphp
                    <li class="border-b pb-2 flex items-center justify-between">
                        <a href="{{ route('conversations.show', $thread->id) }}" class="flex items-center gap-4">
                            @if($participantUser && $participantUser->profile_picture)
                                <img src="{{ asset($participantUser->profile_picture) }}" alt="{{ $participantUser->name }}" class="w-12 h-12 rounded-full">
                            @else
                                <img src="{{ asset('default-profile.png') }}" alt="Default Profile" class="w-12 h-12 rounded-full">
                            @endif
                            <div>
                                <p class="text-blue-500 hover:text-blue-700 font-medium">
                                    {{ $thread->subject }}
                                </p>
                                @if($participantUser)
                                    <p class="text-gray-500 text-sm">
                                        {{ $participantUser->firstname }} {{ $participantUser->lastname }}
                                    </p>
                                @endif
                            </div>
                        </a>
                        @if($thread->unread_count > 0)
                            <span class="bg-red-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                {{ $thread->unread_count }}
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</x-app-layout>
