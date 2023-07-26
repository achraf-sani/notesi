<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Major;
use App\Models\Module;
use App\Models\Course;

class CoursesController extends Controller
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

    /**
     * function to controll access to courses space
     */
    public function getCoursesCpanel() {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            return view("cpanel.courses");
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
    }
    
    /**
     * function to parse uploaded file and update database.
     */
    public function addCourses(Request $request) {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {//if the user has rights
            $updated = array();
            $created = array();
            foreach($request->file('files') as $key => $file) {
                //dd($key, $file);
                $name = $file->getClientOriginalName();
                $name = substr($name, 0, strlen($name) - 4);//remove .csv
                $semester_majorAbbrev = explode("_", $name);
                $semesterName = $semester_majorAbbrev[0];
                $majorAbbrev = $semester_majorAbbrev[1];
                //get semester id 
                $semesterId = Semester::where('semesterName', $semesterName)->first()->semesterId;
                //dd($semesterId);
                //get Major Id
                $majorId = Major::where('majorAbbreviation', $majorAbbrev)->where('semesterId', $semesterId)->first()->majorId;
                //dd($semester, $majorAbbrev);
                $filePath = $file->getRealPath();
                $file_open = fopen($filePath, "r");
                while (($column = fgetcsv($file_open, 10000, ",")) !== False){
                    $moduleAbbrev = $column[0];
                    $courseAbbrev = $column[1];
                    $courseName = $column[2];
                    $courseCoeff = floatval($column[3]);
                    //dd($moduleAbbrev, $majorId);
                    $moduleId = Module::where('moduleAbbreviation', $moduleAbbrev)->where('moduleMajor', $majorId)->first()->moduleId;

                //  dd($moduleAbbrev, $courseCoeff, $courseAbbrev, $majorId, $moduleId);
                    $insert_courses = Course::dontCache()->updateOrCreate(
                        [
                            'moduleId' => $moduleId,//the module for this major
                            'courseAbbreviation' => $courseAbbrev,
                        ],
                        [
                            'courseName' => utf8_encode($courseName),
                            'courseCoeff' => $courseCoeff,//if exists update coeff
                        ]
                    );
                    
                    if(!$insert_courses->wasRecentlyCreated && $insert_courses->wasChanged()){
                        // updateOrCreate performed an update
                        array_push($updated, $insert_courses);
                    }

                    if($insert_courses->wasRecentlyCreated){
                    // updateOrCreate performed create
                        array_push($created, $insert_courses);
                    }   
                    // if(!$insert_courses->wasRecentlyCreated && !$insert_courses->wasChanged()){
                    //     // updateOrCreate performed nothing, row did not change
                    // }

                }
            }
            Course::flushQueryCache();
            return view('cpanel.courses', ['updated' => $updated, 'created' => $created]);
        } 
        else {
             //TO DO FOR 9ssi
             return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
        }
        
    }
}
