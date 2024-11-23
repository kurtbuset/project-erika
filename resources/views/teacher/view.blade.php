@extends('layouts.teacher')
@section('contents')
    <h1>Student: {{ $student->name }}</h1>

    <h2>Grades:</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if ($view ?? false)
    <a href="{{ route('teacher.edit.grade', $student) }}">edit grade</a>
    @endif

    @if ($editing ?? false)
        {{-- Form for editing all grades --}}
        <form action="{{ route('teacher.update.all.grades', $student->id) }}" method="post">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-primary mb-3">Submit All Grades</button>
    @endif

    <table class="table w-75">
        <tr>
            <th>Quarter</th>
            <th>Grade</th>
        </tr>
        @foreach ($student->grades as $g)
            <tr>
                <td>{{ $g->quarter }}</td>
                <td>
                    @if ($editing ?? false)
                        {{-- Input for editing grades --}}
                        <input type="number" name="grades[{{ $g->id }}]" value="{{ $g->grade }}" class="form-control" required>
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
    </table>

    @if ($editing ?? false)
        {{-- Close the form --}}
        </form>
    @endif
@endsection
