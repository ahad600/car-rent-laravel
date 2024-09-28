@extends('layout.app')
@section('content')
    @include('component.admin.Header')
    @include('component.admin.RentList')
    @include('component.admin.Footer')
    <script>
        (async () => {
            await RentalList()
            $(".loader-fallback").hide();
        })()
    </script>
@endsection
