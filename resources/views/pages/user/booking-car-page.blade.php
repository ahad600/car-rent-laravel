@extends('layout.app')
@section('content')
    @include('component.user.Header', ["is_dark"=> 1])
    @include('component.user.CarBooking')
    @include('component.user.Footer')
    <script>
        (async () => {
            await getCar();
            $(".loader-fallback").hide();
        })()
    </script>
@endsection