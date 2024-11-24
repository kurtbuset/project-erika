<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;

class RegistrarController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query();

        // Apply search filter
        if ($request->has('search') && !empty($request->get('search'))) {
            $students = $students->where('name', 'like', '%' . $request->get('search') . '%');
        }

        // Apply section filter
        if ($request->has('section') && !empty($request->get('section'))) {
            $students = $students->where('class_id', $request->get('section'));
        }

        // Fetch all sections for the dropdown
        $sections = Section::all();

        // Paginate the filtered results
        $students = $students->paginate(5);

        return view('registrar.index', compact('students', 'sections'));
    }

    public function show(Student $student)
    {
        // Fetch student with their grades
        $student->load('grades');

        // Calculate the general average
        $average = $student->grades->avg('grade');

        return view('registrar.show', compact('student', 'average'));
    }
}
