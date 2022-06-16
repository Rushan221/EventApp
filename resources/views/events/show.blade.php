@extends('layout.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$event->title}}</h3>
            @if($event->is_completed)
                <span class="badge bg-success">Completed</span>
            @else
                <span class="badge bg-danger">Not Completed</span>
            @endif
        </div>
        <div class="card-body">
            <p>From <strong>{{$event->start_date}}</strong> to <strong>{{$event->end_date}}</strong></p>
            <p>{{$event->description}}</p>
        </div>
        <div class="card-footer">
            <a href="{{route('event.index')}}" class="btn btn-primary"> <i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>
@endsection
