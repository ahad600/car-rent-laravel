@extends('layout.app')
@section('content')

    @include('component.user.Header', ["is_dark"=> 1])
    @include('component.user.Login')
    @include('component.user.Footer')

    <script>
        (async () => {
            $(".loader-fallback").hide();
        })()
    </script>


@endsection