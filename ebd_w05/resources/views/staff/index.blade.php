@extends('../layouts.app')

@section('title','ebd-w05 - Staff')

@section('header')
    <h1 class="text-center text-4xl text-red-600 my-4">Staff (บุคลากร)</h1>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="overflow-x-auto">
            <div class="mb-4">
                <a href="{{ route('staff.create') }}" class="btn btn-success">Add Staff</a>
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
                        <th>คำนำหน้า</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>หน่วยงาน</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staffs as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title->title_name }}</td>
                        <td>{{ $item->first_name }}</td>
                        <td>{{ $item->last_name }}</td>
                        <td>{{ $item->organization->org_name }}</td>
                        <td>
                            <form action="{{ route('staff.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-warning" href="{{ route('staff.edit',$item->id) }}">Edit</a>
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
