<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Major;


class StudentsController extends Controller
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
     * function to controll access to students space
     */
    public function getStudentsCpanel() {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            return view("cpanel.students");
        }
        //TO DO FOR 9ssi
        return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
    }
    
    /**
     * function to parse uploaded file and update database.
     */
    public function addStudents(Request $request) {
        if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0) {
            $updated = array();
            $created = array();
            foreach($request->file('files') as $key => $file) {
                //dd($key, $file);
                $name = $file->getClientOriginalName();
                $name = substr($name, 0, strlen($name) - 4);//remove .csv
                $semester_majorAbbrev_promo = explode("_", $name);
                $semesterName = $semester_majorAbbrev_promo[0];
                $majorAbbrev = $semester_majorAbbrev_promo[1];
                $promotion = intval($semester_majorAbbrev_promo[2]);
                //dd($semester_majorAbbrev_promo);
                //dd($promotion);
                //get semester id 
                $semesterId = Semester::where('semesterName', $semesterName)->first()->semesterId;
                //dd($semesterId);
                //get Major Id
                $majorId = Major::where('majorAbbreviation', $majorAbbrev)->where('semesterId', $semesterId)->first()->majorId;
                //dd($semester, $majorAbbrev);
                $filePath = $file->getRealPath();
                $file_open = fopen($filePath, "r");
                while (($column = fgetcsv($file_open, 10000, ",")) !== False){
                    $firstName = $column[0];
                    $lastName = $column[1];
                    $group = $column[2];
                    $fullName = strtolower(preg_replace("/[^A-Za-z\w]/", '', $firstName.$lastName));
    
                   // dd($fullName, $group);
                    $insert_courses = Student::dontCache()->updateOrCreate(
                        [
                            'firstName' => utf8_encode($firstName),
                            'lastName' => utf8_encode($lastName),
                            'fullName' => utf8_encode($fullName),
                            'studentPromo' => $promotion,
                            'studentGroup' => $group,
                            'studentMajor' => $majorId,
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
                }
          
            }
            Student::flushQueryCache();
            //fix
            return view('cpanel.students', ['updated' => $updated, 'created' => $created]);
        }
        else {
            return redirect()->route("errorPage")->withErrors(['msg' => "You don't have permission to access this page.!"]);
        }
        
    }
}
