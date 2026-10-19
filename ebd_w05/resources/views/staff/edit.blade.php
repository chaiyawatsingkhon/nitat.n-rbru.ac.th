@extends('../layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-2">
                <h2>Edit Staff</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('staff.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <form action="{{ route('staff.update', $staff->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group mb-2">
                    <strong>Title (คำนำหน้า):</strong>
                    <select class="py-2 px-3 text-gray-700 border rounded w-full" name="title_id">
                        <option value="">Select Title</option>
                        @foreach($titles as $title)
                            <option value="{{ $title->id }}" {{ $staff->title_id == $title->id ? 'selected' : '' }}>{{ $title->title_name }}</option>
                        @endforeach
                    </select>
                    @error('title_id')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <strong>First Name:</strong>
                    <input class="py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border rounded w-full" name="first_name" type="text" value="{{ $staff->first_name }}" placeholder="First Name">
                    @error('first_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <strong>Last Name:</strong>
                    <input class="py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border rounded w-full" name="last_name" type="text" value="{{ $staff->last_name }}" placeholder="Last Name">
                    @error('last_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <strong>Organization (หน่วยงาน):</strong>
                    <select class="py-2 px-3 text-gray-700 border rounded w-full" name="organization_id">
                        <option value="">Select Organization</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ $staff->organization_id == $org->id ? 'selected' : '' }}>{{ $org->org_name }}</option>
                        @endforeach
                    </select>
                    @error('organization_id')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3 mt-2">Submit</button>
        </div>
    </form>
</div>
@endsection
