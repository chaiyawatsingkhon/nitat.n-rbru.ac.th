@extends('../layouts.app')

@section('title','ebd-w05 - Tag')

@section('header')
    <h1 class="text-center text-4xl text-red-600 my-4">Tag (แท็ก)</h1>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="overflow-x-auto">
            <div class="mb-4">
                <a href="{{ route('tag.create') }}" class="btn btn-success">Add Tag</a>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success mb-4">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table-auto table-zebra w-8/12 ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>คำอธิบาย</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->tag_name }}</td>
                        <td>
                            <form action="{{ route('tag.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-warning" href="{{ route('tag.edit',$item->id) }}">Edit</a>
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
