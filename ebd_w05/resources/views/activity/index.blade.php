@extends('../layouts.app')

@section('title','ebd-w05 - Activities')

@section('header')
    <h1 class="text-center text-4xl text-red-600 my-4">Activities (กิจกรรม)</h1>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="overflow-x-auto">
            <div class="mb-4">
                <a href="{{ route('activity.create') }}" class="btn btn-success">Add Activity</a>
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
                        <th>ชื่อกิจกรรม</th>
                        <th>วันที่จัดกิจกรรม</th>
                        <th>ชุมชน</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->activity_name }}</td>
                        <td>{{ $item->activity_date }}</td>
                        <td>{{ $item->community->community_name }}</td>
                        <td>
                            <form action="{{ route('activity.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-warning" href="{{ route('activity.edit',$item->id) }}">Edit</a>
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
