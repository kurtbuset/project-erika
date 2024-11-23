@extends('layouts.teacher')
@section('title', 'dashboard')
@section('contents')

<p>Good morning: {{ $teacher->name }}</p>

<h1>schedule of classes</h1>
@endsection