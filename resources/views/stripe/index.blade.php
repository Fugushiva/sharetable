<form action="{{route('book.store')}}" method="post" id="redirectForm">
    @csrf
    <input type="hidden" name="annonce_id" value="{{ session('annonce_id') }}">
    <script>
        document.getElementById('redirectForm').submit();
    </script>
</form>
