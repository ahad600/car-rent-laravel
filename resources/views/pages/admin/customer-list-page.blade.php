@extends('layout.app')
@section('content')
    @include('component.admin.Header')
    @include('component.admin.CustomerList')
    @include('component.admin.Footer')
    <script>
        (async () => {
            await CustomerList()
            $(".loader-fallback").hide();
        })()
    </script>
@endsection
