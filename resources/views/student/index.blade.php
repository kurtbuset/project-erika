@extends('layouts.student')

@section('contents')
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <h2>Your Grades:</h2>
    
    <table class="table w-75">
        <tr>
            <th>Quarter</th>
            <th>Grade</th>
        </tr>
        @foreach ($grades as $grade)
            <tr>
                <td>{{ $grade->quarter }}</td>
                <td>{{ $grade->grade }}</td>
            </tr>
        @endforeach
        <tr>
            <td><strong>General Average</strong></td>
            <td><strong>{{ number_format($average, 2) }}</strong></td>
        </tr>
    </table>
@endsection
