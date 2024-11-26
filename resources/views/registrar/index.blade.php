@extends('layouts.layout')
@section('title', 'Dashboard')
@section('contents')


<!-- Search Form -->
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
            {{ session('success') }}
            <button type="button" class="btn btn-outline-success" id="liveAlertBtn" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>
    @endif
    <div class="card shadow mb-4 p-3">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Students</h6>
            <form method="GET" action="{{ route('registrar.index') }}">
                <div class="d-flex">
                    <div>
                        <select id="section" name="section" class="text-secondary border border-1 rounded p-2 ms-3" onchange="this.form.submit()">
                            <option value="" {{ request()->get('section') == '' ? 'selected' : '' }}>All Students</option>
                            @foreach ($sections as $class)
                                <option class="text-secondary" value="{{ $class->id }}" {{ request()->get('section') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
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
                            <th>Student name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Student name</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>
                                <a href="{{ route('registrar.show', $student->id) }}" class="btn btn-primary">View Grades</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No students found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination d-flex justify-content-end">
            {{ $students->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>



@endsection
