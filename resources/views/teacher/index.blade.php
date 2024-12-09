@extends('layouts.layout')
@section('title', 'Manage Grades')
@section('contents')
<div class="container-fluid">
    <div class="card shadow mb-4 p-3">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Teacher: {{ $teacher->name }}</h6>

            <div class="d-flex" style="gap: 10px;">
                <div>
                    <select id="level" name="level" class="text-secondary border border-1 rounded p-2 ms-3">
                        <option value="">Choose Level</option>
                        @foreach ($levels as $level)
                        <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select id="section" name="section" class="text-secondary border border-1 rounded p-2 ms-3">
                        <option value="">Choose Section</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ request('section') == $section->id ? 'selected' : '' }}>
                            {{ $section->section_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group m-1">
                    <input type="text" id="search" class="form-control bg-light border-1 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2" value="">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="clearSearch">
                            <i class="fas fa-times fa-sm"></i> Clear
                        </button>
                    </div>
                </div>

            </div>
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
    $(document).ready(function() {
        function fetchStudents() {
            let level = $('#level').val();
            let section = $('#section').val();
            let search = $('#search').val();

            $.ajax({
                url: "{{ route('teacher.filter.students') }}",
                type: "GET",
                data: {
                    level: level,
                    section: section,
                    search: search
                },
                success: function(data) {
                    $('#studentTableBody').empty();
                    if (data.length > 0) {
                        $.each(data, function(key, student) {
                            $('#studentTableBody').append(`
                                <tr>
                                    <td>${student.id}</td>
                                    <td>${student.name}</td>
                                    <td>
                                        <a href="/teacher/view/${student.id}" class="btn btn-info">View</a>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#studentTableBody').append('<tr><td colspan="3">No students found.</td></tr>');
                    }
                },
                error: function() {
                    alert('Failed to fetch students. Please try again.');
                }
            });
        }

        // Handle level and section changes
        $('#level').on('change', function() {
            let level = $(this).val();
            if (level) {
                $.ajax({
                    url: "{{ route('teacher.get.sections.by.level') }}",
                    type: "GET",
                    data: {
                        level: level
                    },
                    success: function(data) {
                        $('#section').empty().append('<option value="">Choose Section</option>');
                        $.each(data, function(key, section) {
                            $('#section').append(`<option value="${section.id}">${section.section_name}</option>`);
                        });
                        fetchStudents(); // Fetch students after updating sections
                    },
                    error: function() {
                        alert('Failed to fetch sections. Please try again.');
                    }
                });
            } else {
                $('#section').empty().append('<option value="">Choose Section</option>');
                fetchStudents(); // Fetch students when level is cleared
            }
        });

        $('#section').on('change', fetchStudents);

        // Handle search input changes
        $('#search').on('keyup', function() {
            fetchStudents(); // Fetch students whenever search input changes
        });

        // Clear search input
        $('#clearSearch').on('click', function() {
            $('#search').val('');
            fetchStudents();
        });
    });
</script>

@endsection