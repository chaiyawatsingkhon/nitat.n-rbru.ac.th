@extends('layouts.app')

@section('title', 'จัดการคำนำหน้าชื่อ')

@section('header')
<h1 class="text-center text-4xl font-bold text-blue-600 mb-6">จัดการคำนำหน้าชื่อ (Title)</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-4 text-center border">ID</th>
                <th class="p-4 border">คำนำหน้าชื่อ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($titles as $item)
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-4 text-center border">{{ $item->id }}</td>
                <td class="p-4 border">{{ $item->title_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection