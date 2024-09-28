@extends('layout.app')
@section('content')
    {{-- @include('component.user.Header') --}}
    @include('component.user.Home')
    @include('component.user.Footer')

    <script>
        (async () => {
            await CartList()
            $(".loader-fallback").hide();
        })()
    </script>
@endsection

