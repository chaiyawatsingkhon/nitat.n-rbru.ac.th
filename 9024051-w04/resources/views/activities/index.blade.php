@extends('layouts.app')

@section('title', 'จัดการรายการกิจกรรม')

@section('header')
<h1 class="text-center text-4xl font-bold text-blue-600 mb-6">จัดการรายการกิจกรรม (Activities)</h1>
@endsection

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-4 text-center border">ID</th>
                <th class="p-4 border">ชื่อกิจกรรม</th>
                <th class="p-4 border">ชุมชน</th>
                <th class="p-4 border">องค์กร</th>
                <th class="p-4 border text-center">วันที่จัดกิจกรรม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $item)
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-4 text-center border">{{ $item->id }}</td>
                <td class="p-4 border">{{ $item->activity_name }}</td>
                <td class="p-4 border">{{ $item->community->community_name ?? '' }}</td>
                <td class="p-4 border">{{ $item->organization->org_name ?? '' }}</td>
                <td class="p-4 border text-center">{{ $item->activity_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
