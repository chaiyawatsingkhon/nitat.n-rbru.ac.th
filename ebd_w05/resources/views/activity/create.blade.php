@extends('../layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-2">
                <h2>Add Activity</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('activity.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <form action="{{ route('activity.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group mb-2">
                    <strong>Activity Name:</strong>
                    <input class="py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border rounded w-full" name="activity_name" type="text" placeholder="Activity Name">
                    @error('activity_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <strong>Date (วันที่จัดกิจกรรม):</strong>
                    <input class="py-2 px-3 text-gray-700 border rounded w-full" name="activity_date" type="date">
                    @error('activity_date')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <strong>Community (ชุมชน):</strong>
                    <select class="py-2 px-3 text-gray-700 border rounded w-full" name="community_id">
                        <option value="">Select Community</option>
                        @foreach($communities as $com)
                            <option value="{{ $com->id }}">{{ $com->community_name }}</option>
                        @endforeach
                    </select>
                    @error('community_id')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3 mt-2">Submit</button>
        </div>
    </form>
</div>
@endsection
