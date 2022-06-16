@extends('layout.app')
@section('content')
    <form method="POST" action="{{ route('event.update',$event->id) }}">
        @csrf
        @method('PUT')
        @include('events.form')
    </form>
@endsection
@section('js')
    <script>
        let startDate = {!! json_encode($event->start_date) !!};
        let endDate = {!! json_encode($event->end_date) !!};
        $(document).ready(function () {
            $('.date-range-picker').daterangepicker({
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " to ",
                },
                startDate: startDate,
                endDate: endDate
            });
        });
    </script>
@endsection
