@extends('layout.app')
@section('content')

    @include('component.user.Header', ["is_dark"=> 1])
    @include('component.user.Singup')
    @include('component.user.Footer')
    <script>
        (async () => {
            $(".loader-fallback").hide();
        })()
    </script>

@endsection