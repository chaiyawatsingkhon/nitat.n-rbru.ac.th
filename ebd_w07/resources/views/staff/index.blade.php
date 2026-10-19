@extends('layouts.app')

@section('title','ebd-w0')

@section('header')
    <h1 class="text-center text-6xl text-red-600 prompt-bold">Tag</h1>
@endsection
   
@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <a class="inline-block font-bold rounded text-sm bg-blue-500 hover:bg-green-500/80 text-white px-4 py-2"
             href="{{ route('staff.create') }}"> Create Lecturer</a>
        </div>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ</th>
                        <th>หน่วยงาน</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staffs as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title->tit_name }}
                            {{ $item->fname }}
                            {{ $item->lname }}
                        </td>
                        <td>{{ $item->organization->org_name }}</td>
                        <td>
                            <form action="{{ route('staff.destroy',$item->id) }}" method="Post" class="flex gap-2">
                                <a class="btn btn-sm btn-primary w-20" href="{{ route('staff.edit',$item->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-20">Delete</button>
                                <a class="btn btn-sm btn-warning w-20" href="{{ route('staff.show',$item->id) }}">Detail</a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
