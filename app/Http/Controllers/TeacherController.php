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
    public function index()
    {
        $teacher = Auth::user();

        // Fetch the students who belong to the teacher's classes
        $students = Student::whereHas('section', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('section')->get();

        $sections = $teacher->sections;

        return view('teacher.index', compact('students', 'teacher', 'sections'));
    }

    public function showSchedule(){
        $teacher = Auth::user();
        return view('teacher.schedule', compact('teacher'));
    }
    
    public function view(Student $student){
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
