@extends('layouts.layout')
@section('title', 'grades')
@section('contents')


<div class="container-fluid">
<div class="card shadow mb-4 p-3">
<div class="card-header py-3 d-flex flex-column">
    <h3>Welcome, {{ auth()->user()->name }}!</h3>
    <h6 class="m-0 font-weight-bold text-primary">Your Grades:</h6>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Quarter</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endsection
