<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class RegistrarController extends Controller
{
    public function index(Request $request){
        $students = Student::with('grades');

        // If there is a search query, filter students based on their names or other attributes
        if ($request->has('search')) {
            $search = $request->get('search');
            $students = $students->where('name', 'like', '%' . $search . '%');
        }

        $students = $students->paginate(5); 
        // Paginate the results
        return view('registrar.index', compact('students'));
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
