<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Monolog\Level;

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

    public function addStudent()
    {

        $levels = Section::distinct()->pluck('level'); // Get unique levels
        $sections = Section::all(); // Fetch all sections
        return view('registrar.add', compact('levels', 'sections'));
    }

    public function storeStudent()
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'level' => 'required|exists:sections,level', // Validate level exists in sections
            'section' => 'required|exists:sections,id',  // Validate section exists in sections
        ]);

        // Check if the selected section belongs to the selected level
        $section = Section::where('id', request('section'))
            ->where('level', request('level'))
            ->first();

        if (!$section) {
            return back()->withErrors(['section' => 'The selected section does not match the selected level.'])->withInput();
        }

        // Create user
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'type' => 0,
        ]);

        // Create student and store the matching section_id
        $student = Student::create([
            'name' => request('name'),
            'user_id' => $user->id,
            'section_id' => $section->id, // Store the section ID
        ]);

        // Create default grades for the student
        $quarters = ['1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter'];
        foreach ($quarters as $quarter) {
            Grade::create([
                'student_id' => $student->id,
                'quarter' => $quarter,
                'grade' => 0, // Default grade
            ]);
        }

        return redirect(route('registrar.index'))->with('success', 'Student added successfully');
    }



    public function getSectionsByLevel(Request $request)
    {
        $sections = Section::where('level', $request->level)->get(['id', 'section_name']);
        return response()->json($sections);
    }
}
