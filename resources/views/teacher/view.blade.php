@extends('layouts.layout')
@section('contents')

<div class="container-fluid">
<div class="card shadow mb-4 p-3">
<div class="card-header py-3 d-flex justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Student: {{ $student->name }}</h6>
</div>

<div class="card-body">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
            {{ session('success') }}
            <button type="button" class="btn btn-outline-success" id="liveAlertBtn" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>
    @endif
    

    @if ($view ?? false)
    <a class="btn btn-primary mb-3" href="{{ route('teacher.edit.grade', $student) }}">Edit Grade</a>
    @endif
    @if ($editing ?? false)
    {{-- Form for editing all grades --}}
    <form action="{{ route('teacher.update.all.grades', $student->id) }}" method="post">
        @csrf
        @method('put')
        <input type="submit" class="btn btn-primary mb-3"></input>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <td>Quarter</td>
                <td>Grade</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($student->grades as $g)
                <tr>
                    <td>{{ $g->quarter }}</td>
                    <td>
                        @if ($editing ?? false)
                            {{-- Input for editing grades --}}
                            <input type="number" step="0.01" name="grades[{{ $g->id }}]" value="{{ $g->grade }}" class="form-control" required>
                            @error("grades.$g->id")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @else
                            {{-- Static display of grade --}}
                            {{ $g->grade }}
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>General Average</td>
                <td><strong>{{ number_format($average, 2) }}</strong></td>
            </tr>
            </tbody>
        </table>
        @if ($editing ?? false)
        {{-- Close the form --}}
            </form>
        @endif
    </div>
</div>
</div>
</div>
@endsection