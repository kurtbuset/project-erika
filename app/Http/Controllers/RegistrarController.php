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
    public function dashboard(){
        $studentsCount = Student::count(); // Count total students
        $sectionsCount = Section::count(); // Count total sections
        $teachersCount = User::where('type', 1)->count();
        return view('registrar.dashboard', compact('studentsCount', 'sectionsCount', 'teachersCount'));
    }
    public function index(Request $request)
    {
        $levels = Section::distinct('level')->pluck('level');
        $sections = collect();

        if ($request->has('level') && $request->level != '') {
            $sections = Section::where('level', $request->level)->get();
        }

        $students = Student::with('section')
            ->whereHas('section', function ($query) use ($request) {
                if ($request->has('level') && $request->level != '') {
                    $query->where('level', $request->level);
                }

                if ($request->has('section') && $request->section != '') {
                    $query->where('id', $request->section);
                }
            })
            ->get();

        return view('registrar.index', compact('levels', 'sections', 'students'));
    }



    public function filterStudents(Request $request)
    {
        $sections = [];
        if ($request->has('level') && $request->level != '') {
            $sections = Section::where('level', $request->level)->get(['id', 'section_name']);
        }


        $students = Student::with('section')
            ->whereHas('section', function ($query) use ($request) {
                if ($request->level) {
                    $query->where('level', $request->level);
                }

                if ($request->section) {
                    $query->where('id', $request->section);
                }
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%'); // Search by name
            })
            ->get(['id', 'name']);

        return response()->json([
            'students' => $students,
            'sections' => $sections
        ]);
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
