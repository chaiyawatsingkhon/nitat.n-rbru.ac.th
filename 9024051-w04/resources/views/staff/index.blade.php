@extends('layouts.app')

@section('title', 'จัดการรายชื่อเจ้าหน้าที่')

@section('header')
<h1 class="text-center text-4xl font-bold text-blue-600 mb-6">จัดการรายชื่อเจ้าหน้าที่ (Staff)</h1>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-4 text-center border">ID</th>
                <th class="p-4 border">ชื่อ - นามสกุล</th>
                <th class="p-4 border">ตำแหน่ง</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staffs as $item)
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-4 text-center border">{{ $item->id }}</td>
                <td class="p-4 border">{{ $item->title->title_name ?? '' }}{{ $item->first_name }} {{ $item->last_name }}</td>
                <td class="p-4 border">{{ $item->position }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection