@extends('layouts.app')


@section('title','ebd-w0-Insert Tag')


@section('header')
    <h1 class="text-center text-6xl text-red-600">Insert Tag</h1>
@endsection


@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-2">
                <h2>Add Staff</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('staff.index') }}"> Back</a>
            </div>
        </div>
    </div>
    @if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
    @endif
    <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <select name="tit_id" id="tit_id" class=" py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($titles as $item)
                            <option value="{{ $item->id}}">
                                {{ $item->tit_name}}
                            </option>
                        @endforeach
                    </select>
                    @error('tit_id')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <strong>Firstname :</strong>
                    <input class=" py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="fname" type="text" placeholder="Fullname">
                    @error('fname')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <strong>Lastname :</strong>
                    <input class=" py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="lname" type="text" placeholder="Lastname">
                    @error('lname')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <strong>Organization-:</strong>
                    <select name="org_id" id="org_id" class=" py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($organizations as $item)
                            <option value="{{ $item->id}}">
                                {{ $item->org_name}}
                            </option>
                        @endforeach
                    </select>
                    @error('org_id')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>


            </div>
            <button type="submit" class="btn btn-primary ml-3">Submit</button>
        </div>
    </form>
</div>
@endsection
