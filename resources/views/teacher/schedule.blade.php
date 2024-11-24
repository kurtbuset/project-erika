@extends('layouts.teacher')
@section('title', 'dashboard')
@section('contents')
<div class="container-fluid">
<div class="card shadow mb-4 p-3">
<div class="card-header py-3 d-flex justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Good day! {{ $teacher->name }}</h6>
</div>

<div class="card-body">
    

<h1>schedule of classes</h1>
</div>
</div>
</div>

@endsection