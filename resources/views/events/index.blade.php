@extends('layout.app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>
                {{$eventType}}
            </h3>
            <div class="d-flex justify-content-between">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Event filters
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{route('event.index',['key'=>'all'])}}">All Events</a></li>
                        <li><a class="dropdown-item" href="{{route('event.index',['key'=>'finished'])}}">Finished Events</a></li>
                        <li><a class="dropdown-item" href="{{route('event.index',['key'=>'upcoming'])}}">Upcoming Events</a></li>
                        <li><a class="dropdown-item" href="{{route('event.index',['key'=>'upcoming-in-7'])}}">Upcoming
                                events within 7 days</a></li>
                        <li><a class="dropdown-item" href="{{route('event.index',['key'=>'finished-of-7'])}}">Finished events of the last 7 days</a></li>
                    </ul>
                </div>&nbsp;
                <a href="{{route('event.create')}}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Create</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Is Complete?</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{$event->title}}</td>
                        <td>{{$event->start_date}}</td>
                        <td>{{$event->end_date}}</td>
                        <td>
                            @if($event->is_completed)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-danger">Not Completed</span>
                            @endif
                        </td>
                        <td class="d-flex align-content-center">
                            <a href="{{ route('event.edit',$event->id) }}" class="btn btn-primary btn-sm"
                               title="Edit"><i class="fa fa-pen-to-square"></i></a>&nbsp;
                            <a href="{{ route('event.show',$event->id) }}" class="btn btn-primary btn-sm"
                               title="Edit"><i class="fa-solid fa-eye"></i></a>&nbsp;
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-btn"
                               rel="{{$event->id}}"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.delete-btn').click(function () {
                let deleteBtn = $(this);
                let eventId = deleteBtn.attr('rel');
                Swal.fire({
                    title: 'Do you want to delete the event?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('event.destroy') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                eventId
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    deleteBtn.closest('tr').fadeOut(1000);
                                    Swal.fire(response.message, '', 'success')
                                } else {
                                    Swal.fire(response.message, '', 'warning')
                                }
                            },
                            error: function (err) {
                                Swal.fire('Internal server error', '', 'error')
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
