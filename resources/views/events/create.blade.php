@extends('layout.app')
@section('content')
    <form method="POST" action="{{ route('event.store') }}">
        @csrf
        @include('events.form')
    </form>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('.date-range-picker').daterangepicker({
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " to ",
                }
            });
        });
    </script>
@endsection
