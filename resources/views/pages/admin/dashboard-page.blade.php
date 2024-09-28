@extends('layout.app')
@section('content')
    @include('component.admin.Header')
    @include('component.admin.Dashboard')
    @include('component.admin.Footer')
    <script>
        (async () => {
            $(".loader-fallback").hide();
        })()
    </script>
@endsection