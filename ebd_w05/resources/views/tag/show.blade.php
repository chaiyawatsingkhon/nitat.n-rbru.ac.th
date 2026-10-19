@extends('../layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-2">
                <h2>Tag Detail</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tag.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <ul>
        <li>id : {{ $tag->id}}</li>
        <li>description : {{ $tag->tag_name }}</li>
    </ul>

</div>
@endsection
