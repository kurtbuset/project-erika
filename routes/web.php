<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/',[AuthController::class, 'loginAction'])->name('login.action');  
Route::get('/logout',[AuthController::class, 'logout'])->middleware('auth')->name('logout');



Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/grades', [StudentController::class, 'showGrades'])->name('student.index');
});


Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/list-of-students', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/teacher/schedule', [TeacherController::class, 'showSchedule'])->name('teacher.show.schedule');
    Route::get('teacher/get-sections-by-level', [TeacherController::class, 'getSectionsByLevel'])->name('teacher.get.sections.by.level');
    Route::get('/filter-students', [TeacherController::class, 'filterStudents'])->name('filter.students');
    Route::get('/teacher/{student}/grade', [TeacherController::class, 'view'])->name('teacher.view');
    Route::get('/teacher/edit-grade/{student}', [TeacherController::class, 'editGrade'])->name('teacher.edit.grade');
    Route::put('/students/{student}/grades/update-all', [TeacherController::class, 'updateAllGrades'])->name('teacher.update.all.grades');
    

});


Route::middleware(['auth', 'role:registrar'])->group(function () {
    Route::get('/registrar/add-student', [RegistrarController::class, 'addStudent'])->name('registrar.add.student');
    Route::get('/registrar', [RegistrarController::class, 'index'])->name('registrar.index');
    Route::get('/registrar/get-sections-by-level', [RegistrarController::class, 'getSectionsByLevel'])->name('registrar.get.sections.by.level');
    Route::post('/registrar/store', [RegistrarController::class, 'storeStudent'])->name('registrar.store');
    Route::get('/registrar/{student}', [RegistrarController::class, 'show'])->name('registrar.show');
    
});

Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
});