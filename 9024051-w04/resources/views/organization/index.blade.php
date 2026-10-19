@extends('layouts.app')

@section('title', 'จัดการข้อมูลองค์กร')

@section('header')
<h1 class="text-center text-4xl font-bold text-blue-600 mb-6">จัดการข้อมูลองค์กร (Organization)</h1>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-4 text-center border">ID</th>
                <th class="p-4 border">ชื่อองค์กร</th>
                <th class="p-4 border">รายละเอียด</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($organizations as $item)
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-4 text-center border">{{ $item->id }}</td>
                <td class="p-4 border">{{ $item->org_name }}</td>
                <td class="p-4 border">{{ $item->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection