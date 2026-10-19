@extends('../layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-2">
                <h2>Add Organization</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('organization.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <form action="{{ route('organization.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group mb-2">
                    <strong>Organization Name:</strong>
                    <input class="py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border rounded w-full" name="org_name" type="text" placeholder="Organization Name">
                    @error('org_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <strong>Address:</strong>
                    <input class="py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border rounded w-full" name="org_address" type="text" placeholder="Address">
                    @error('org_address')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3 mt-2">Submit</button>
        </div>
    </form>
</div>
@endsection
