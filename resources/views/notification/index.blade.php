<x-app-layout>
    @section('content')
        <div class="notifications">
            <ul>
                @foreach (auth()->user()->unreadNotifications as $notification)
                    <li>{{ $notification->data['message'] }}</li>
                @endforeach
            </ul>
            <form action="{{route('notification.read')}}" method="POST">
                @csrf
                <button type="submit">Mark all as read</button>
            </form>
        </div>
    @endsection
</x-app-layout>
