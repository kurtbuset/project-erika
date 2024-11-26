<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
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

    public function addStudent(){
        $sections = Section::all();
        return view('registrar.add', compact('sections'));
    }

    public function storeStudent(){
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'section' => 'required|exists:sections,id'
        ]);
        
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'type' => 0
        ]);

        $student = Student::create([
            'name' => request('name'),
            'user_id' => $user->id,
            'class_id' => request('section')
        ]);

        $quarters = ['1st', '2nd', '3rd', '4th']; // Define quarters
        foreach ($quarters as $quarter) {
            Grade::create([
                'student_id' => $student->id,
                'quarter' => $quarter,
                'grade' => 0, // Default grade
            ]);
        }
        return redirect(route('registrar.index'))->with('success', 'Student added succesfully');
    }
}
