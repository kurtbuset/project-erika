@extends('layouts.student')
@section('title', 'Dashboard')
@section('contents')

<h1>All Students</h1>

<a href="{{route('registrar.index')}}">bc logo</a>

<!-- Search Form -->
<form action="{{ route('registrar.index') }}" method="GET">
    <input type="text" name="search" id="search" placeholder="Search students" value="{{ request()->get('search') }}">
    <button type="submit">Search</button>
</form>

<!-- Students Table -->
<table class="table table-bordered w-50">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>
                    <a href="{{ route('registrar.show', $student->id) }}" class="btn btn-primary">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination Links -->
<div class="pagination">
    {{ $students->appends(request()->except('page'))->links() }}
</div>

@endsection
