@extends('layouts.teacher')
@section('title', 'Student Grades')
@section('contents')

<h1>Grades for {{ $student->name }}</h1>

<table class="table table-bordered w-75">
    <thead>
        <tr>
            <th>Quarter</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($student->grades as $grade)
            <tr>
                <td>{{ $grade->quarter }}</td>
                <td>{{ $grade->grade }}</td>
            </tr>
        @endforeach
        <tr>
            <td><strong>General Average</strong></td>
            <td><strong>{{ number_format($average, 2) }}</strong></td>
        </tr>
    </tbody>
</table>

<a href="{{ route('registrar.index') }}" class="btn btn-secondary">Back to Students</a>

@endsection
