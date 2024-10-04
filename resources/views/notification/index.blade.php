<x-app-layout>
    @section('content')
        <div class="notifications">
            <ul>
                @foreach (auth()->user()->unreadNotifications as $notification)
                    @php
                        // Décoder le JSON encodé dans la méthode toArray()
                        $data = json_decode($notification->data, true);
                    @endphp
                    <li>
                        <a href="{{ $data['url'] }}">
                            {{ $data['message'] }}
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
