@extends('../layouts.app')

@section('title','ebd-w05 - Organization')

@section('header')
    <h1 class="text-center text-4xl text-red-600 my-4">Organization (หน่วยงาน)</h1>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="overflow-x-auto">
            <div class="mb-4">
                <a href="{{ route('organization.create') }}" class="btn btn-success">Add Organization</a>
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
                        <th>ชื่อหน่วยงาน</th>
                        <th>ที่อยู่</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($organizations as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->org_name }}</td>
                        <td>{{ $item->org_address }}</td>
                        <td>
                            <form action="{{ route('organization.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-warning" href="{{ route('organization.edit',$item->id) }}">Edit</a>
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
