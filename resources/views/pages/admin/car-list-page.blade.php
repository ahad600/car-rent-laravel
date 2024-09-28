@extends('layout.app')
@section('content')
    @include('component.admin.Header')
    @include('component.admin.CartList')
    @include('component.admin.Footer')

    <script>
        (async () => {
            await CartList();
            $(".loader-fallback").hide();
        })()
    </script>



@endsection





