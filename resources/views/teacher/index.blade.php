@extends('layouts.layout')
@section('title', 'Manage Grades')
@section('contents')
<div class="container-fluid">
    <div class="card shadow mb-4 p-3">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Teacher: {{ $teacher->name }}</h6>

            <form method="GET" action="{{ route('teacher.index') }}">
                <div class="d-flex" style="gap: 10px;">
                    <div>
                        <select id="level" name="level" class="text-secondary border border-1 rounded p-2 ms-3">
                            <option value="">Choose level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select id="section" name="section" class="text-secondary border border-1 rounded p-2 ms-3">
                            <option value="">Choose section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}" {{ request('section') == $section->id ? 'selected' : '' }}>
                                    {{ $section->section_name }}
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
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    <a href="{{ route('teacher.view', $student->id) }}" class="btn btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    $('#level').on('change', function () {
        let level = $(this).val(); // Get the selected level
        if (level) {
            $.ajax({
                url: "{{ route('teacher.get.sections.by.level') }}", // Adjust the route
                type: "GET",
                data: { level: level },
                success: function (data) {
                    // console.log(data)
                    $('#section').empty(); // Clear the dropdown
                    $('#section').append('<option value="">Choose Section</option>'); // Add default option
                    if (data.length > 0) {
                        $.each(data, function (key, section) {
                            $('#section').append(`<option value="${section.id}">${section.section_name}</option>`);
                        });
                    }
                },
                error: function () {
                    alert('Failed to fetch sections. Please try again.');
                }
            });
        } else {
            $('#section').empty();
            $('#section').append('<option value="">Choose Section</option>');
        }
    });
});

</script>
@endsection
