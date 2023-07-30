<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Major;
use App\Models\Module;
use App\Models\Course;
use App\Models\Mark;
use Illuminate\Support\Facades\DB;

class MarksController extends Controller
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
     * function to controll access to marks space
     */
    public function getMarksCpanel() {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            return view("cpanel.marks");
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' =>"You don't have permission to access this page.!"]);
    }
    
    /**
     * function to parse uploaded file and update database.
     */
    public function addMarks(Request $request) {
        set_time_limit(0);
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            $updated = array();
            $created = array();
            foreach($request->file('files') as $key => $file) {
                //dd($key, $file);
                $name = $file->getClientOriginalName();
                $name = substr($name, 0, strlen($name) - 4);//remove .csv
                $semester_majorAbbrev_moduleAbbrev_elementAbbrev_promo = explode("_", $name);
                $semesterName = $semester_majorAbbrev_moduleAbbrev_elementAbbrev_promo[0];
                $majorAbbrev = $semester_majorAbbrev_moduleAbbrev_elementAbbrev_promo[1];
                $moduleAbbrev = $semester_majorAbbrev_moduleAbbrev_elementAbbrev_promo[2];
                $courseAbbrev = $semester_majorAbbrev_moduleAbbrev_elementAbbrev_promo[3];
                $promotion = intval($semester_majorAbbrev_moduleAbbrev_elementAbbrev_promo[4]);
                //get semester id 
                $semesterId = Semester::where('semesterName', $semesterName)->first()->semesterId;
                //dd($semesterId);
                //get Major Id
                $majorId = Major::where('majorAbbreviation', $majorAbbrev)->where('semesterId', $semesterId)->first()->majorId;
                //dd($semester, $majorAbbrev);
                //get Module Id
                $moduleId = Module::where('moduleAbbreviation', $moduleAbbrev)->where('moduleMajor', $majorId)->first()->moduleId;
                //get Course Id
                $courseId = Course::where('courseAbbreviation', $courseAbbrev)->where('moduleId', $moduleId)->first()->courseId;
                $filePath = $file->getRealPath();
                $file_open = fopen($filePath, "r");

                

                //DB::enableQueryLog();
                while (($column = fgetcsv($file_open, 10000, ",")) !== False){
                    $firstName = $column[0];
                    $lastName = $column[1];
                    $mark = floatval($column[2]);
                    $fullName = strtolower(preg_replace("/[^A-Za-z\w]/", '', $firstName.$lastName));

                    $studentIds = Student::where('fullName', $fullName)->where('studentPromo', $promotion)->get();
                    foreach($studentIds as $student) {
                        if ($student->major->semesterId == $semesterId){
                            $studentId = $student->studentId;
                        }
                    }
                    //dd($studentId);
                    //dd($fullName, $studentId, $mark);
                    
                    $markId = $studentId . "." . $courseId;
                    
                    if ($request->input("isRatt") == "0" ){
                        $insert_courses = Mark::dontCache()->updateOrCreate(
                            [
                                'markId' => $markId,//find by markId
                            ],
                            [
                                'courseId' => $courseId,
                                'studentId' => $studentId,
                                'mark' => $mark,//if exists update mark
                                'ratt' => false,
                            ]
                        );
                    }else{
                        $insert_courses = Mark::dontCache()->updateOrCreate(
                            [
                                'markId' => $markId,//find by markId
                            ],
                            [
                                'courseId' => $courseId,
                                'studentId' => $studentId,
                                'mark' => $mark,//if exists update mark
                                'ratt' => true,
                            ]
                        );
                    }
                    if(!$insert_courses->wasRecentlyCreated && $insert_courses->wasChanged()){
                        // updateOrCreate performed an update
                        array_push($updated, $insert_courses);
                    }

                    if($insert_courses->wasRecentlyCreated){
                    // updateOrCreate performed create
                        array_push($created, $insert_courses);
                    }   
                    
                }
               // dd(DB::getQueryLog());
            
            }
            //updates done flush cache
            Mark::flushQueryCache();
            return view('cpanel.marks', ['updated' => $updated, 'created' => $created]);

        }
        else {
            return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
        }

        
    }
}
