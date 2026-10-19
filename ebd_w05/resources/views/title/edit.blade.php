@extends('../layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-2">
                <h2>Edit Title</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('title.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <form action="{{ route('title.update', $title->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title Name:</strong>
                    <input class="py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border rounded" name="title_name" type="text" value="{{ $title->title_name }}" placeholder="Title Name">
                    @error('title_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3 mt-2">Submit</button>
        </div>
    </form>
</div>
@endsection
