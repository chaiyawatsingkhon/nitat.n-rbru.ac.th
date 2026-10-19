@extends('../layouts.app')

@section('title','ebd-w05 - Title')

@section('header')
    <h1 class="text-center text-4xl text-red-600 my-4">Title (คำนำหน้าชื่อ)</h1>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="overflow-x-auto">
            <div class="mb-4">
                <a href="{{ route('title.create') }}" class="btn btn-success">Add Title</a>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success mb-4">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table-auto table-zebra w-8/12">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>คำนำหน้าชื่อ</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($titles as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title_name }}</td>
                        <td>
                            <form action="{{ route('title.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-warning" href="{{ route('title.edit',$item->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
