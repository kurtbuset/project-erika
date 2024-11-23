<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function showGrades()
    {
        $user = auth()->user();

        // Get the associated student
        $student = $user->student;

        // Ensure the student exists
        if (!$student) {
            return redirect()->route('home')->with('error', 'Student data not found!');
        }

        // Retrieve grades for the student
        $grades = $student->grades;
        $average = $grades->avg('grade');

        return view('student.index', compact('student', 'grades', 'average'));
    }

    
}
