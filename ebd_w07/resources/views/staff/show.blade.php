@extends('layouts.app')

@section('content')
<div class="w-2/3 mx-auto my-10">
    <div class="row">
        <div class="">
            <div class="my-4 text-center font-bold">
                <h2>Staff Details</h2>
            </div>
            <div class="pull-right">
                <a class="my-4 font-bold rounded text-xs bg-gray-500 hover:bg-gray-700 text-white p-4" href="{{ route('staff.index') }}">
                    Back</a>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded my-6 p-6 shadow">
        <div class="mb-4">
            <strong>ID:</strong> {{ $staff->id }}
        </div>
        <div class="mb-4">
            <strong>Title:</strong> {{ $staff->title->tit_name ?? 'N/A' }}
        </div>
        <div class="mb-4">
            <strong>Firstname:</strong> {{ $staff->fname }}
        </div>
        <div class="mb-4">
            <strong>Lastname:</strong> {{ $staff->lname }}
        </div>
        <div class="mb-4">
            <strong>Organization:</strong> {{ $staff->organization->org_name ?? 'N/A' }}
        </div>
    </div>
</div>
@endsection
