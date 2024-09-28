@extends('layout.app')
@section('content')

    @include('component.user.Header', ["is_dark"=> 1])
    @include('component.user.ManageBooing')
    @include('component.user.Footer')

    <script>
        (async () => {
            await RentalList()
            $(".loader-fallback").hide();
        })()
    </script>


@endsection