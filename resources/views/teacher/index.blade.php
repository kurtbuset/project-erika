@extends('layouts.teacher')
@section('title', 'manage grades')
@section('contents')

<p>Teacher: {{ $teacher->name }}</p>
<p>Grade and section: 
    @foreach ($sections as $section)
        {{ $section->name }}{{ !$loop->last ? ', ' : '' }}
    @endforeach
</p>

<h1>list of students</h1>
<div>
    <table class="table w-75">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>actions</td>
        </tr>
        
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->name }}</td>
            <td>
                <a href="{{ route('teacher.view', $student->id) }}">view grades</a>
            </td>
            <td>
                
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection