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
                        <div style="width: 35%;">
                            <label for="">Name:</label>
                            <input type="text" 
                                   class="form-control bg-light border-1 small" 
                                   placeholder="your name" 
                                   aria-label="Search" 
                                   aria-describedby="basic-addon2" 
                                   name="name" 
                                   value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-25">
                            <label for="">Email:</label>
                            <input type="email" 
                                   class="form-control bg-light border-1 small" 
                                   placeholder="yourname@gmail.com" 
                                   aria-label="Search" 
                                   aria-describedby="basic-addon2" 
                                   name="email" 
                                   value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="width: 35%;" class="d-flex">
                            <!-- Level Dropdown -->
                            <div>
                                <label for="level">Level:</label>
                                <select id="level" 
                                        name="level" 
                                        class="text-secondary border border-1 rounded p-2 ms-3">
                                    <option value="">Select Level</option>
                                    @foreach ($levels as $level)
                                    <option value="{{ $level }}" 
                                            {{ old('level') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('level')
                                <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Section Dropdown -->
                            <div>
                                <label for="section">Section:</label>
                                <select id="section" 
                                        name="section" 
                                        class="text-secondary border border-1 rounded p-2 ms-3">
                                    <option value="">Select Section</option>
                                    @if (old('section'))
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" 
                                            {{ old('section') == $section->id ? 'selected' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('section')
                                <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="">Password:</label>
                        <input type="password" 
                               class="form-control bg-light border-1 small" 
                               aria-label="Search" 
                               aria-describedby="basic-addon2" 
                               name="password">
                        @error('password')
                        <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="">Confirm Password:</label>
                        <input type="password" 
                               class="form-control bg-light border-1 small" 
                               aria-label="Search" 
                               aria-describedby="basic-addon2" 
                               name="confirm_password">
                        @error('confirm_password')
                        <span class="text-danger" style="font-size: .7em;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center d-flex" style="gap: 1em;">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        
                        <a href="{{ route('registrar.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let level = $('#level').val(); // Get old selected level
        let oldSection = "{{ old('section') }}"; // Get old selected section
        if (level) {
            $.ajax({
                url: "{{ route('registrar.get.sections.by.level') }}", // Update with your route
                type: "GET",
                data: { level: level },
                success: function(data) {
                    $('#section').empty();
                    $('#section').append('<option value="">Select Section</option>');
                    $.each(data, function(key, value) {
                        $('#section').append(
                            `<option value="${value.id}" ${value.id == oldSection ? 'selected' : ''}>
                                ${value.section_name}
                            </option>`
                        );
                    });
                }
            });
        }

        $('#level').on('change', function() {
            let level = $(this).val(); // Get the selected level
            if (level) {
                $.ajax({
                    url: "{{ route('registrar.get.sections.by.level') }}", // Update with your route
                    type: "GET",
                    data: { level: level },
                    success: function(data) {
                        $('#section').empty(); // Clear the dropdown
                        $('#section').append('<option value="">Select Section</option>'); // Add default option
                        $.each(data, function(key, value) {
                            $('#section').append(`<option value="${value.id}">${value.section_name}</option>`);
                        });
                    }
                });
            } else {
                $('#section').empty();
                $('#section').append('<option value="">Select Section</option>');
            }
        });
    });
</script>

@endsection
