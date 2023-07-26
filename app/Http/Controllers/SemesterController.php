<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Semester;

class SemesterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function assignCurrentSemester($id)
    {
       // dd(Auth::user()->userId);
        $userId = Auth::user()->userId;
        //$studentId = Auth::id();
        $students = Student::where('userId', $userId)->get();
        /*
        $currentSemester = new Semester([
            'semesterId' => $id,
        ]);*/
        $currentSemester = Semester::where('semesterId', $id)->first();
        foreach ($students as $student) {
            $student->currentSemester()->associate($currentSemester);
            $student->save();
        }
        //dd($students);
        return redirect()->route('home', [$currentSemester]);
        //->with(["currentSemester" => $currentSemester]);
    }

    public function getCurrentSemester()
    {
        $semester = Auth::user()->students()->dontCache()->first()->currentSemester;
        return redirect()->route('home', [$semester]);
    }
}
