@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error=='The total price field is required.' ? ' please select room before add it to cart': $error}}</p>
        @endforeach
    </div>
@endif