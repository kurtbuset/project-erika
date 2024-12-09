<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    // Show all students of the logged-in teacher's classes
    public function index(Request $request)
    {
        $teacher = Auth::user();

        // Fetch all levels associated with the teacher
        $levels = Section::where('teacher_id', $teacher->id)->distinct('level')->pluck('level');

        // Get sections for the selected level (if available)
        $sections = collect();
        if ($request->has('level') && $request->level != '') {
            $sections = Section::where('level', $request->level)->where('teacher_id', $teacher->id)->get();
        }

        // Fetch students based on level and section
        $students = Student::with('section')
            ->whereHas('section', function ($query) use ($teacher, $request) {
                $query->where('teacher_id', $teacher->id);

                if ($request->has('level') && $request->level != '') {
                    $query->where('level', $request->level);
                }

                if ($request->has('section') && $request->section != '') {
                    $query->where('id', $request->section);
                }
            })
            ->get();

        return view('teacher.index', compact('teacher', 'levels', 'sections', 'students'));
    }




    public function filterStudents(Request $request)
    {
        $teacher = Auth::user();

        // Query students based on level and section
        $students = Student::with('section')
            ->whereHas('section', function ($query) use ($teacher, $request) {
                $query->where('teacher_id', $teacher->id);

                if ($request->has('level') && $request->level != '') {
                    $query->where('level', $request->level);
                }

                if ($request->has('section') && $request->section != '') {
                    $query->where('id', $request->section);
                }
            })
            ->get();

        return response()->json($students);
    }

    public function getSectionsByLevel(Request $request)
    {
        $teacher = Auth::user();

        // Fetch sections for the teacher and the selected level
        $sections = Section::where('level', $request->level)
            ->where('teacher_id', $teacher->id)
            ->get(['id', 'section_name']);


        return response()->json($sections);
    }


    public function showSchedule()
    {
        $teacher = Auth::user();
        return view('teacher.schedule', compact('teacher'));
    }

    public function view(Student $student)
    {
        $student->load('grades');
        $view = true;
        // dd($student->grades);
        $average = $student->grades->avg('grade');
        return view('teacher.view', compact('student', 'average', 'view'));
    }

    public function editGrade(Student $student, Grade $grade)
    {
        $editing = true; // Flag for the editing mode
        $view = false;
        $average = $student->grades->avg('grade'); // Calculate general average
        return view('teacher.view', compact('student', 'grade', 'average', 'editing'));
    }


    public function updateAllGrades(Request $request, Student $student)
    {
        // Validate the input for all grades
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|numeric|min:70|max:100', // Ensure all grades are numeric and valid
        ]);

        // Update each grade
        foreach ($request->grades as $gradeId => $gradeValue) {
            Grade::where('id', $gradeId)->where('student_id', $student->id)->update(['grade' => $gradeValue]);
        }

        // Redirect back with success message
        return redirect()->route('teacher.view', $student->id)->with('success', 'Grades updated successfully!');
    }
}
