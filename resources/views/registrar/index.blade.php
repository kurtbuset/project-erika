@extends('layouts.layout')
@section('title', 'Dashboard')
@section('contents')

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

                

                <button class="btn btn-primary">
                        <a href="{{ route('registrar.add.student') }}" class="text-decoration-none text-white">Add student</a>
                    </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>
                                <a href="{{ route('registrar.show', $student->id) }}" class="btn btn-primary">View Grades</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchStudents() {
            let level = $('#level').val();
            let section = $('#section').val();
            let search = $('#search').val(); // Capture search input value

            $.ajax({
                url: "{{ route('registrar.filter.students') }}",
                type: "GET",
                data: {
                    level: level,
                    section: section,
                    search: search // Pass search query to the server
                },
                success: function(data) {
                    $('#studentTableBody').empty();
                    if (data.students.length > 0) {
                        $.each(data.students, function(key, student) {
                            $('#studentTableBody').append(`
                            <tr>
                                <td>${student.name}</td>
                                <td>
                                    <a href="/registrar/show/${student.id}" class="btn btn-primary">View Grades</a>
                                </td>
                            </tr>
                        `);
                        });
                    } else {
                        $('#studentTableBody').append('<tr><td colspan="2" class="text-center">No students found.</td></tr>');
                    }

                    // Update sections if a level is selected
                    if (data.sections) {
                        $('#section').empty().append('<option value="">Choose Section</option>');
                        $.each(data.sections, function(key, section) {
                            $('#section').append(`<option value="${section.id}">${section.section_name}</option>`);
                        });
                    }
                },
                error: function() {
                    alert('Failed to fetch students. Please try again.');
                }
            });
        }

        // Fetch students when level, section, or search changes
        $('#level').on('change', function() {
            fetchStudents();
        });

        $('#section').on('change', function() {
            fetchStudents();
        });

        $('#search').on('keyup', function() {
            fetchStudents(); // Trigger fetch on typing in search box
        });

        // Clear search input and fetch all students
        $('#clearSearch').on('click', function() {
            $('#search').val(''); // Clear search input
            fetchStudents(); // Fetch all students again
        });
    });
</script>

@endsection