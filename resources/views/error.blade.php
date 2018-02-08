@if ($errors->any())
    <div class="alert alert-danger" style="width: 50%; margin: 1em auto;">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="list-style: none;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif