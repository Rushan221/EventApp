<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create Event</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Warning!</strong> Please check your fields<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="form-group col-md-6">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="title"
                       value="{{ old('title', isset($event->title) ? $event->title:'')}}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="date-range">Start-End Date:</label>
                <input type="text" name="date_range" id="date-range" class="form-control date-range-picker"
                       value="{{ old('start_date', isset($event->start_date) ? $event->start_date .'to'.$event->end_date :'')}}"
                       readonly required>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="description">Description:</label>
            <textarea name="description" id="description"
                      class="form-control" required>{{ old('description', isset($event->description) ? $event->description:'')}}</textarea>
        </div>
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('event.index') }}" class="btn btn-danger">Back</a>
        </div>
    </div>
</div>
