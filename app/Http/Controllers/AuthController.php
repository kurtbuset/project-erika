<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => trans('auth.failed')]);
        }

        $request->session()->regenerate();
        // dd(auth()->check(), auth()->user());
        // Redirect based on user role
        // dd(auth()->user()->type);
        switch (auth()->user()->type) {
            case 'student': // Student
                return redirect(route('student.index'));
            case 'teacher': // Teacher
                return redirect(route('teacher.show.schedule'));
            case 'registrar': // Registrar
                return redirect(route('registrar.index'));
            default:
                Auth::logout();
                // dd('asd');
                return redirect('/login')->with('error', 'Unauthorized role.');
        }
    }



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}
