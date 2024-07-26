<x-app-layout>
    @section('content')
        <div class="notifications">
            <ul>
                @foreach (auth()->user()->unreadNotifications as $notification)
                    <li>
                        <a href="{{ $notification->data['url'] }}">
                            {{ $notification->data['message'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <form action="{{ route('notification.read') }}" method="POST">
                @csrf
                <button type="submit">Mark all as read</button>
            </form>
        </div>
    @endsection
</x-app-layout>
