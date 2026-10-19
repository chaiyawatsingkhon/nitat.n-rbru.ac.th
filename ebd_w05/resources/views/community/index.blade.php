@extends('../layouts.app')

@section('title','ebd-w05 - Community')

@section('header')
    <h1 class="text-center text-4xl text-red-600 my-4">Community (ชุมชน)</h1>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="overflow-x-auto">
            <div class="mb-4">
                <a href="{{ route('community.create') }}" class="btn btn-success">Add Community</a>
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
                        <th>ชื่อชุมชน</th>
                        <th>ที่ตั้ง</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($communities as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->community_name }}</td>
                        <td>{{ $item->community_location }}</td>
                        <td>
                            <form action="{{ route('community.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-warning" href="{{ route('community.edit',$item->id) }}">Edit</a>
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
