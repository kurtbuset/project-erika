@extends('layouts.layout')
@section('title', 'manage grades')
@section('contents')
<div class="container-fluid">
<div class="card shadow mb-4 p-3">
<div class="card-header py-3 d-flex justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Teacher: {{ $teacher->name }}</h6>
    


    <form method="GET" action="{{ route('teacher.index') }}">
        <div class="d-flex">
            <div>
                <select id="section" name="section" class="text-secondary border border-1 rounded p-2 ms-3" onchange="this.form.submit()">
                    <option value="" {{ $selectedSection == '' ? 'selected' : '' }}>All Students</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ $selectedSection == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group m-1">
                <input type="text" class="form-control bg-light border-1 small" placeholder="Search for..." 
                    aria-label="Search" aria-describedby="basic-addon2" name="search" 
                    value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <td>Student id</td>
                <td>Name</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>
                    <a href="{{ route('teacher.view', $student->id) }}" class="btn btn-primary">View Grades</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endsection