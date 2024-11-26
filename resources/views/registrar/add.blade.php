@extends('layouts.layout')
@section('title', 'Add student')
@section('contents')

<div class="container-fluid">
<div class="card shadow mb-4 p-3">
<div class="card-header py-3 d-flex flex-column">
    <h3>Add student</h3>

</div>

<div class="card-body">
    <div class="table-responsive">
        <form action="{{ route('registrar.store') }}" method="post">
            @csrf   
            <div class="w-100 mb-4" style="display: flex; justify-content: between; gap: .5em;">
                <div class="w-50">
                    <label for="">Name:</label>
                    <input type="text" class="form-control bg-light border-1 small" placeholder="your name" aria-label="Search" aria-describedby="basic-addon2" name="name">
                    @error('name')
                        <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-50">
                    <label for="">Email:</label>
                    <input type="email" class="form-control bg-light border-1 small" placeholder="yourname@gmail.com" aria-label="Search" aria-describedby="basic-addon2" name="email">
                    @error('email')
                        <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-25">
                    <label for="section">Student Section:</label>
                    <select id="section" name="section" class="text-secondary border border-1 rounded p-2 ms-3">
                        @foreach ($sections as $class)
                            <option class="text-secondary" value="{{ $class->id }}" {{ request()->get('section') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('section')   
                        <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            


            <div class="mb-4">
                <label for="">Password:</label>
                <input type="password" class="form-control bg-light border-1 small" aria-label="Search" aria-describedby="basic-addon2" name="password" placeholder="•••••••••••">
                @error('password')
                    <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="">Confirm Password:</label>
                <input type="password" class="form-control bg-light border-1 small" aria-label="Search" aria-describedby="basic-addon2" name="confirm_password" placeholder="•••••••••••">
                @error('confirm_password')
                    <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection